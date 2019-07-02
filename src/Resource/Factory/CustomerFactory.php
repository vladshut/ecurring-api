<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Customer\Gender;
use VladShut\eCurring\Resource\Customer\VerificationMethod;
use VladShut\eCurring\Resource\CustomerCollection;
use VladShut\eCurring\Resource\Proxy\SubscriptionProxy;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;

final class CustomerFactory extends AbstractFactory implements CustomerFactoryInterface
{
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): CustomerCollection
    {
        $subscriptions = [];
        foreach ($data['data'] as $data) {
            $subscriptions[] = $this->fromData($data);
        }
        $totalPages = $this->extractInteger('total', $data['meta']);

        return new CustomerCollection($client, $page->getNumber(), $totalPages, $subscriptions);
    }

    public function fromData(eCurringClientInterface $client, array $data): Customer
    {
        return Customer::fromData(
            $this->extractInteger('id', $data),
            $data['attributes']['first_name'],
            $data['attributes']['last_name'],
            PaymentMethod::get($data['attributes']['payment_method']),
            $data['attributes']['email'],
            new DateTimeImmutable($data['attributes']['created_at']),
            new DateTimeImmutable($data['attributes']['updated_at']),
            $this->extractStringOrNull('card_holder', $data['attributes']),
            $this->extractStringOrNull('card_number', $data['attributes']),
            $data['attributes']['gender'] === null ? null : Gender::get($data['attributes']['gender']),
            $this->extractStringOrNull('middle_name', $data['attributes']),
            $this->extractStringOrNull('company_name', $data['attributes']),
            $this->extractStringOrNull('vat_number', $data['attributes']),
            $this->extractStringOrNull('postalcode', $data['attributes']),
            $this->extractStringOrNull('house_number', $data['attributes']),
            $this->extractStringOrNull('house_number_add', $data['attributes']),
            $this->extractStringOrNull('street', $data['attributes']),
            $this->extractStringOrNull('city', $data['attributes']),
            $this->extractStringOrNull('country_iso2', $data['attributes']),
            $this->extractStringOrNull('language', $data['attributes']),
            $this->extractStringOrNull('telephone', $data['attributes']),
            $data['attributes']['bank_verification_method'] === null ? null : VerificationMethod::get($data['attributes']['bank_verification_method']),
            ...$this->getSubscriptionProxies($client, $data['relationships'])
        );
    }

    /**
     * @return SubscriptionProxy[]
     */
    private function getSubscriptionProxies(eCurringClientInterface $client, array $relationships): array
    {
        if (!isset($relationships['subscriptions'])) {
            return [];
        }

        $subscriptions = [];

        foreach ($relationships['subscriptions']['data'] as $subscription) {
            if ($subscription['type'] !== 'subscription') {
                continue;
            }

            $subscriptions[] = new SubscriptionProxy($client, $subscription['id']);
        }

        return $subscriptions;
    }
}
