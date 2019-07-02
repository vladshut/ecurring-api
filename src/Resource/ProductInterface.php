<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Product\AuthenticationMethod;
use VladShut\eCurring\Resource\Product\Status;

/**
 * @method int getId()
 * @method string getName()
 * @method string getDescription()
 * @method DateTimeImmutable getStartDate()
 * @method Status getStatus()
 * @method AuthenticationMethod getMandateAuthenticationMethod()
 * @method bool isSendInvoice()
 * @method int getStornoRetries()
 * @method string|null getTerms()
 * @method SubscriptionInterface[] getSubscriptions()
 * @method DateTimeImmutable getCreatedAt()
 * @method DateTimeImmutable getUpdatedAt()
 */
interface ProductInterface
{
}
