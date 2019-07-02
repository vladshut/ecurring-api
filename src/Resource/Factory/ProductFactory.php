<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Product;
use VladShut\eCurring\Resource\Product\AuthenticationMethod;
use VladShut\eCurring\Resource\Product\Status;
use VladShut\eCurring\Resource\ProductCollection;
use VladShut\eCurring\Resource\Proxy\SubscriptionProxy;

final class ProductFactory extends AbstractFactory implements ProductFactoryInterface
{
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): ProductCollection
    {
        $transactions = [];
        foreach ($data['data'] as $data) {
            $transactions[] = $this->fromData($client, $data);
        }

        $totalPages = $data['meta']['total'];

        return new ProductCollection($client, $page->getNumber(), $totalPages ?? 1, $transactions, $page->getSize());
    }

    public function fromData(eCurringClientInterface $client, array $data): Product
    {
        return new Product(
            $this->extractInteger('id', $data),
            $data['attributes']['name'],
            $data['attributes']['description'],
            new DateTimeImmutable($data['attributes']['start_date']),
            Status::get($data['attributes']['status']),
            AuthenticationMethod::get($data['attributes']['mandate_authentication_method']),
            $this->extractBoolean('send_invoice', $data['attributes']),
            $this->extractInteger('storno_retries', $data['attributes']),
            new DateTimeImmutable($data['attributes']['created_at']),
            new DateTimeImmutable($data['attributes']['updated_at']),
            $this->extractStringOrNull('terms', $data['attributes']),
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
            if ($subscription['type']  !== 'subscription') {
                continue;
            }

            $subscriptions[] = new SubscriptionProxy($client, $subscription['id']);
        }

        return $subscriptions;
    }
}
