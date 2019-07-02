<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Http\Resource\Creatable;
use VladShut\eCurring\Http\Resource\Updatable;
use VladShut\eCurring\Resource\Exception\MandateNotAcceptedException;
use VladShut\eCurring\Resource\Subscription\Mandate;
use VladShut\eCurring\Resource\Subscription\Status;

final class Subscription implements SubscriptionInterface, Creatable, Updatable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Mandate
     *
     * The unique mandate code which is generated when creating a subscription.
     */
    private $mandate;

    /**
     * @var DateTimeImmutable
     *
     * The start date of the subscription.
     * Transactions will be planned relative from this date.
     * If the start date is in the future, eCurring won't charge any amounts before the specific date.
     */
    private $startDate;

    /**
     * @var Status
     *
     * The current status of the subscription.
     */
    private $status;

    /**
     * @var DateTimeImmutable|null
     *
     * If a subscription has the status cancelled,
     * this indicates the moment at which the subscription has been cancelled.
     * When the date is in the future this indicates when the subscription will automatically be cancelled.
     */
    private $cancelDate;

    /**
     * @var DateTimeImmutable|null
     *
     * If a subscription has the status paused,
     * this indicates on which date the subscription will be activated again.
     */
    private $resumeDate;

    /**
     * @var string
     *
     * The URL which allows customers to accept their mandate and activate their subscription.
     */
    private $confirmationPage;

    /**
     * @var bool
     *
     * Indicates whether the above confirmation page was sent to the customer,
     * which is the default when a subscription is created without an accepted mandate.
     */
    private $confirmationSent;

    /**
     * @var string|null
     *
     * The webhook URL we will call when the status of the subscription changes.
     */
    private $subscriptionWebhookUrl;

    /**
     * @var string|null
     *
     * The webhook URL we will call when the status of a transaction, scheduled by this subscription, changes.
     */
    private $transactionWebhookUrl;

    /**
     * @var string|null
     *
     * The URL we will redirect the client to after a successful activation of the subscription
     * (after the customer approved the mandate).
     */
    private $successRedirectUrl;

    /**
     * @var ProductInterface
     *
     * The subscription plan which is attached to the subscription
     */
    private $subscriptionPlan;

    /**
     * @var CustomerInterface
     *
     * The customer which the subscription belongs to
     */
    private $customer;

    /**
     * @var TransactionInterface[]
     */
    private $transactions;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the subscription was created
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the subscription was last updated
     */
    private $updatedAt;

    private function __construct()
    {
    }

    public static function fromData(
        int $id,
        Mandate $mandate,
        DateTimeImmutable $startDate,
        Status $status,
        string $confirmationPage,
        bool $confirmationSent,
        CustomerInterface $customer,
        ProductInterface $subscriptionPlan,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        ?string $subscriptionWebhookUrl,
        ?string $transactionWebhookUrl,
        ?string $successRedirectUrl,
        ?DateTimeImmutable $cancelDate,
        ?DateTimeImmutable $resumeDate,
        ?TransactionInterface ...$transactions
    ): self {
        $self = new self();
        $self->id = $id;
        $self->mandate = $mandate;
        $self->startDate = $startDate;
        $self->status = $status;
        $self->confirmationPage = $confirmationPage;
        $self->confirmationSent = $confirmationSent;
        $self->subscriptionWebhookUrl = $subscriptionWebhookUrl;
        $self->transactionWebhookUrl = $transactionWebhookUrl;
        $self->successRedirectUrl = $successRedirectUrl;
        $self->subscriptionPlan = $subscriptionPlan;
        $self->customer = $customer;
        $self->createdAt = $createdAt;
        $self->updatedAt = $updatedAt;
        $self->cancelDate = $cancelDate;
        $self->resumeDate = $resumeDate;
        $self->transactions = $transactions;

        return $self;
    }

    public static function new(
        CustomerInterface $customer,
        ProductInterface $subscriptionPlan,
        ?Mandate $mandate = null,
        ?DateTimeImmutable $startDate = null,
        ?DateTimeImmutable $cancelDate = null,
        ?DateTimeImmutable $resumeDate = null,
        ?bool $confirmationSent = false,
        ?Status $status = null,
        ?string $subscriptionWebhookUrl = null,
        ?string $transactionWebhookUrl = null

    ): self {
        $self = new self();
        $self->customer = $customer;
        $self->subscriptionPlan = $subscriptionPlan;
        $self->mandate = $mandate;
        $self->startDate = $startDate;
        $self->cancelDate = $cancelDate;
        $self->resumeDate = $resumeDate;
        $self->confirmationSent = $confirmationSent;
        $self->status = $status;
        $self->subscriptionWebhookUrl = $subscriptionWebhookUrl;
        $self->transactionWebhookUrl = $transactionWebhookUrl;

        return $self;
    }

    /**
     * @throws MandateNotAcceptedException
     */
    public function activate(): void
    {
        if ($this->mandate->isAccepted() !== true) {
            throw new MandateNotAcceptedException();
        }

        $this->status = Status::active();
    }

    public function pause(): void
    {
        $this->status = Status::paused();
    }

    public function cancel(): void
    {
        $this->status = Status::cancelled();
    }

    public function setStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setCancelDate(?DateTimeImmutable $cancelDate): void
    {
        $this->cancelDate = $cancelDate;
    }

    public function setResumeDate(?DateTimeImmutable $resumeDate): void
    {
        $this->resumeDate = $resumeDate;
    }

    public function setConfirmationSent(bool $confirmationSent): void
    {
        $this->confirmationSent = $confirmationSent;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMandate(): ?Mandate
    {
        return $this->mandate;
    }

    public function getStartDate(): ?DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getCancelDate(): ?DateTimeImmutable
    {
        return $this->cancelDate;
    }

    public function getResumeDate(): ?DateTimeImmutable
    {
        return $this->resumeDate;
    }

    public function getConfirmationPage(): string
    {
        return $this->confirmationPage;
    }

    public function isConfirmationSent(): ?bool
    {
        return $this->confirmationSent;
    }

    public function getSubscriptionWebhookUrl(): ?string
    {
        return $this->subscriptionWebhookUrl;
    }

    public function getTransactionWebhookUrl(): ?string
    {
        return $this->transactionWebhookUrl;
    }

    public function getSuccessRedirectUrl(): ?string
    {
        return $this->successRedirectUrl;
    }

    public function getSubscriptionPlan(): ProductInterface
    {
        return $this->subscriptionPlan;
    }

    public function getCustomer(): CustomerInterface
    {
        return $this->customer;
    }

    /**
     * @return TransactionInterface[]|null
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
