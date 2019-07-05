<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\SubscriptionCollection;

interface SubscriptionFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data, array $included = null): Subscription;

    /**
     * @return Subscription[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): SubscriptionCollection;
}
