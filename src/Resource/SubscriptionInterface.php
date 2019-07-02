<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Subscription\Status;

/**
 * @method int getId()
 * @method string getMandate()
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
interface SubscriptionInterface
{
}
