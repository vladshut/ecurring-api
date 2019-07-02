<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Transaction;
use VladShut\eCurring\Resource\TransactionCollection;

interface TransactionFactoryInterface
{
    public function fromData(array $data): Transaction;

    /**
     * @return Transaction[]
     */
    public function fromSubscriptionArray(
        eCurringClientInterface $client,
        array $data,
        Subscription $subscription,
        Pagination $page
    ): TransactionCollection;
}
