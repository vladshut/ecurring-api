<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Product\AuthenticationMethod;
use VladShut\eCurring\Resource\Product\Status;

final class Product implements ProductInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     * The administrative name of the subscription plan
     */
    private $name;

    /**
     * @var string
     *
     * The description of the subscription plan as shown to your customers
     */
    private $description;

    /**
     * @var DateTimeImmutable
     *
     * The start date of the subscription plan.
     * If this date is in the future, no transactions will be scheduled until this date is reached.
     * You can, however, already add subscriptions to the plan before it starts.
     */
    private $startDate;

    /**
     * @var Status
     *
     * The current status of the subscription plan.
     */
    private $status;

    /**
     * @var AuthenticationMethod
     *
     * The method used for authenticating the mandate of new subscribers.
     * NOTE: the ideal method has been deprecated and replaced by the online_payment method.
     */
    private $mandateAuthenticationMethod;

    /**
     * @var boolean
     *
     * Whether the invoices for the transactions should be sent to the customers by email.
     * Invoices are sent 2 days before the expected collection date.
     */
    private $sendInvoice;

    /**
     * @var int
     *
     * The amount of times a transaction should be retried after a chargeback.
     * For example, a $stornoRetries count of 2 could result in a total of 3 collection attempts.
     */
    private $stornoRetries;

    /**
     * @var string|null
     *
     * The URL to the terms of service attached to the subscription plan
     */
    private $terms;

    /**
     * @var Subscription
     *
     * The subscriptions attached to the plan
     */
    private $subscriptions;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the subscription plan was created
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the subscription plan was last updated
     */
    private $updatedAt;

    public function __construct(
        int $id,
        string $name,
        string $description,
        DateTimeImmutable $startDate,
        Status $status,
        AuthenticationMethod $mandateAuthenticationMethod,
        bool $sendInvoice,
        int $stornoRetries,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        ?string $terms,
        ?SubscriptionInterface ...$subscriptions
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->startDate = $startDate;
        $this->status = $status;
        $this->mandateAuthenticationMethod = $mandateAuthenticationMethod;
        $this->sendInvoice = $sendInvoice;
        $this->stornoRetries = $stornoRetries;
        $this->subscriptions = $subscriptions;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->terms = $terms;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getMandateAuthenticationMethod(): AuthenticationMethod
    {
        return $this->mandateAuthenticationMethod;
    }

    public function isSendInvoice(): bool
    {
        return $this->sendInvoice;
    }

    public function getStornoRetries(): int
    {
        return $this->stornoRetries;
    }

    public function getTerms(): ?string
    {
        return $this->terms;
    }

    /**
     * @return SubscriptionInterface[]|
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
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
