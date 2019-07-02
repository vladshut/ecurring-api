<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Http\Resource\Creatable;
use VladShut\eCurring\Http\Resource\Deletable;
use VladShut\eCurring\Resource\Transaction\Event;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;
use VladShut\eCurring\Resource\Transaction\Status;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

final class Transaction implements TransactionInterface, Creatable, Deletable
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var Status
     *
     * The current status of the transaction.
     */
    private $status;

    /**
     * @var DateTimeImmutable
     *
     * The date on which this transaction was scheduled
     * Generally this is the date on which the subscription was activated.
     */
    private $scheduledOn;

    /**
     * @var DateTimeImmutable|null
     *
     * The date on which the transaction will be, or was, executed.
     * Usually a transaction will be fulfilled within 3 days of this date
     * If a transaction was rescheduled after a charge back,
     * this attribute will reflect the date of the next attempt.
     */
    private $dueDate;

    /**
     * @var Money
     *
     * The amount of the transaction.
     */
    private $amount;

    /**
     * @var DateTimeImmutable|null
     *
     * The date on which the transaction was cancelled.
     * Only filled if $status is 'cancelled'
     */
    private $canceledOn;

    /**
     * @var string|null
     *
     * The webhook URL we will call when the status of this transaction changes,
     * inherited from the subscription.
     */
    private $webhookUrl;

    /**
     * @var PaymentMethod
     *
     * The payment method used for this transaction.
     * For fullfilled transactions this is the actual method used,
     * for future transactions this will be payment method used for the first attempt.
     * However, the method may change if the attempt fails and the transaction is
     * fulfilled through other means (a payment reminder, for example).
     */
    private $paymentMethod;

    /**
     * @var Event[]
     *
     * Collection of events with the full life cycle history of the transaction
     */
    private $history;

    /**
     * @var Subscription|null
     */
    private $subscription;

    private function __construct(Money $amount)
    {
        $this->amount = $amount;
        $this->history = [];
    }

    public static function new(
        Subscription $subscription,
        Money $amount,
        ?DateTimeImmutable $dueDate = null
    ): self {
        $self = new self($amount);
        $self->dueDate = $dueDate;
        $self->subscription = $subscription;

        return $self;
    }

    public static function fromData(
        UuidInterface $id,
        Status $status,
        DateTimeImmutable $scheduledOn,
        Money $amount,
        PaymentMethod $paymentMethod,
        ?DateTimeImmutable $dueDate = null,
        ?DateTimeImmutable $canceledOn = null,
        ?string $webhookUrl = null,
        ?Event ...$history
    ): self {
        $self = new self($amount);
        $self->id = $id;
        $self->status = $status;
        $self->scheduledOn = $scheduledOn;
        $self->dueDate = $dueDate;
        $self->amount = $amount;
        $self->canceledOn = $canceledOn;
        $self->webhookUrl = $webhookUrl;
        $self->paymentMethod = $paymentMethod;
        $self->history = $history;

        return $self;
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getScheduledOn(): ?DateTimeImmutable
    {
        return $this->scheduledOn;
    }

    public function getDueDate(): ?DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }

    public function getCanceledOn(): ?DateTimeImmutable
    {
        return $this->canceledOn;
    }

    public function getWebhookUrl(): ?string
    {
        return $this->webhookUrl;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function getSubscription(): ?Subscription
    {
        return $this->subscription;
    }
}
