<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory\Transaction;

use VladShut\eCurring\Resource\Transaction\Event;

final class EventFactory implements EventFactoryInterface
{
    public function fromArray(array $data): array
    {
        return [];
    }
}
