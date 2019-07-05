<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use DateTimeImmutable;
use InvalidArgumentException;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Proxy\CustomerProxy;
use VladShut\eCurring\Resource\Proxy\ProductProxy;
use VladShut\eCurring\Resource\Proxy\TransactionProxy;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Subscription\Mandate;
use VladShut\eCurring\Resource\Subscription\Status;
use VladShut\eCurring\Resource\SubscriptionCollection;

final class SubscriptionFactory extends AbstractFactory implements SubscriptionFactoryInterface
{
    /** @var CustomerFactory */
    private $customerFactory;

    /** @var ProductFactory */
    private $productFactory;

    /** @var TransactionFactory */
    private $transactionFactory;

    /**
     * SubscriptionFactory constructor.
     * @param CustomerFactory $customerFactory
     * @param ProductFactory $productFactory
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(
        CustomerFactory $customerFactory,
        ProductFactory $productFactory,
        TransactionFactory $transactionFactory
    ) {
        $this->customerFactory = $customerFactory;
        $this->productFactory = $productFactory;
        $this->transactionFactory = $transactionFactory;
    }

    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): SubscriptionCollection
    {
        $subscriptions = [];
        foreach ($data['data'] as $data) {
            $subscriptions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new SubscriptionCollection($client, $page->getNumber(), $totalPages, $subscriptions);
    }

    public function fromData(eCurringClientInterface $client, array $data, array $included = null): Subscription
    {
        $customer = $this->getCustomerProxy($client, $data['relationships']);
        $subscriptionPlan = $this->getSubscriptionPlanProxy($client, $data['relationships']);
        $transactions = [];

        if (!empty($included)) {
            foreach ($included as $item) {
                if ($item['type'] === 'customer') {
                    $customer = $this->customerFactory->fromData($client, $item);
                } elseif ($item['type'] === 'subscription-plan') {
                    $subscriptionPlan = $this->productFactory->fromData($client, $item);
                } elseif ($item['type'] === 'transaction') {
                    $transactions[] = $this->transactionFactory->fromData($item);
                }
            }
        }

        $transactions = empty($transactions) ? $this->getTransactionProxies($client, $data['relationships']) : $transactions;

        $subscription = Subscription::fromData(
            $this->extractInteger('id', $data),
            $this->getMandate($data['attributes']),
            new DateTimeImmutable($data['attributes']['start_date']),
            Status::get($data['attributes']['status']),
            $data['attributes']['confirmation_page'],
            $this->extractBoolean('confirmation_sent', $data['attributes']),
            $customer,
            $subscriptionPlan,
            new DateTimeImmutable($data['attributes']['created_at']),
            new DateTimeImmutable($data['attributes']['updated_at']),
            $this->extractStringOrNull('subscription_webhook_url', $data['attributes']),
            $this->extractStringOrNull('transaction_webhook_url', $data['attributes']),
            $this->extractStringOrNull('success_redirect_url', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('cancel_date', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('resume_date', $data['attributes']),
            ...$transactions
        );

        return $subscription;
    }

    private function getMandate(array $data): Mandate
    {
        return new Mandate(
            $data['mandate_code'],
            $this->extractBoolean('mandate_accepted', $data),
            $this->extractDateTimeImmutableOrNull('mandate_accepted_date', $data)
        );
    }

    private function getSubscriptionPlanProxy(eCurringClientInterface $client, array $relationships): ProductProxy
    {
        if (!isset($relationships['subscription-plan'])) {
            throw new InvalidArgumentException('customer not found in data');
        }

        return new ProductProxy($client, $relationships['subscription-plan']['data']['id']);
    }

    private function getCustomerProxy(eCurringClientInterface $client, array $relationships): CustomerProxy
    {
        if (!isset($relationships['customer'])) {
            throw new InvalidArgumentException('customer not found in data');
        }

        return new CustomerProxy($client, $relationships['customer']['data']['id']);
    }

    /**
     * @param eCurringClientInterface $client
     * @param array $relationships
     * @return TransactionProxy[]
     */
    private function getTransactionProxies(eCurringClientInterface $client, array $relationships): array
    {
        if (!isset($relationships['transactions'])) {
            return [];
        }

        $transactions = [];

        foreach ($relationships['transactions']['data'] as $subscription) {
            if ($subscription['type'] !== 'transaction') {
                continue;
            }

            $transactions[] = new TransactionProxy($client, $subscription['id']);
        }

        return $transactions;
    }
}
