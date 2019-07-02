<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Proxy;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Transaction;
use VladShut\eCurring\Resource\Transaction\Event;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;
use VladShut\eCurring\Resource\Transaction\Status;
use VladShut\eCurring\Resource\TransactionInterface;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @method UuidInterface|null getId()
 * @method Status|null getStatus()
 * @method DateTimeImmutable|null getScheduledOn()
 * @method DateTimeImmutable|null getDueDate()
 * @method Money getAmount()
 * @method DateTimeImmutable|null getCanceledOn()
 * @method string|null getWebhookUrl()
 * @method PaymentMethod getPaymentMethod()
 * @method Event[] getHistory()
 */
final class TransactionProxy extends AbstractProxy implements TransactionInterface
{
    /**
     * @return Transaction
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getTransaction(Uuid::fromString($id));
    }
}
