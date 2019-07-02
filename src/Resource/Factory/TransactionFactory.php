<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Factory\Transaction\EventFactoryInterface;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Transaction;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;
use VladShut\eCurring\Resource\Transaction\Status;
use VladShut\eCurring\Resource\TransactionCollection;
use Money\Money;
use Ramsey\Uuid\Uuid;

final class TransactionFactory extends AbstractFactory implements TransactionFactoryInterface
{
    /**
     * @var EventFactoryInterface
     */
    private $eventFactory;

    public function __construct(EventFactoryInterface $eventFactory)
    {
        $this->eventFactory = $eventFactory;
    }

    public function fromSubscriptionArray(eCurringClientInterface $client, array $data, Subscription $subscription, Pagination $page): TransactionCollection
    {
        $transactions = [];
        foreach ($data['data'] as $data) {
            $transactions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new TransactionCollection($subscription, $client, $page->getNumber(), $totalPages, $transactions);
    }

    public function fromData(array $data): Transaction
    {
        return Transaction::fromData(
            Uuid::fromString($data['id']),
            Status::get($data['attributes']['status']),
            new DateTimeImmutable($data['attributes']['scheduled_on']),
            Money::EUR($this->extractFloat('amount', $data['attributes'])*100),
            PaymentMethod::get($data['attributes']['payment_method']),
            $this->extractDateTimeImmutableOrNull('due_date', $data['attributes']),
            $this->extractDateTimeImmutableOrNull('canceled_on', $data['attributes']),
            $this->extractStringOrNull('webhook_url', $data['attributes']),
            ...$this->eventFactory->fromArray($data['attributes']['history'])
        );
    }
}
