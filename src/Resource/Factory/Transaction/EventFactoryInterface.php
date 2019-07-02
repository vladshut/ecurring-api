<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory\Transaction;

use VladShut\eCurring\Resource\Transaction\Event;

interface EventFactoryInterface
{
    /**
     * @return Event[]
     */
    public function fromArray(array $data): ?array;
}
