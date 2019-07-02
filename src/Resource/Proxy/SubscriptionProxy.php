<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Proxy;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\CustomerInterface;
use VladShut\eCurring\Resource\ProductInterface;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\Subscription\Mandate;
use VladShut\eCurring\Resource\Subscription\Status;
use VladShut\eCurring\Resource\SubscriptionInterface;
use VladShut\eCurring\Resource\TransactionInterface;

/**
 * @method int getId()
 * @method Mandate getMandate()
 * @method DateTimeImmutable getStartDate()
 * @method Status getStatus()
 * @method DateTimeImmutable|null getCancelDate()
 * @method DateTimeImmutable|null getResumeDate()
 * @method string getConfirmationPage()
 * @method bool isConfirmationSent()
 * @method string|null getSubscriptionWebhookUrl()
 * @method string|null getTransactionWebhookUrl()
 * @method string|null getSuccessRedirectUrl()
 * @method ProductInterface getSubscriptionPlan()
 * @method CustomerInterface getCustomer()
 * @method TransactionInterface[]|null getTransactions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
final class SubscriptionProxy extends AbstractProxy implements SubscriptionInterface
{
    /**
     * @return Subscription
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getSubscription($id);
    }
}
