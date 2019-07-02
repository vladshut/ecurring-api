<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Transaction\Event;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;
use VladShut\eCurring\Resource\Transaction\Status;
use Money\Money;
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
interface TransactionInterface
{
}
