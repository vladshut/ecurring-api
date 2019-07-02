<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\CustomerCollection;

interface CustomerFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): Customer;

    /**
     * @return Customer[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): CustomerCollection;
}
