<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Proxy;

use DateTimeImmutable;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Product;
use VladShut\eCurring\Resource\Product\AuthenticationMethod;
use VladShut\eCurring\Resource\Product\Status;
use VladShut\eCurring\Resource\ProductInterface;
use VladShut\eCurring\Resource\SubscriptionInterface;

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
final class ProductProxy extends AbstractProxy implements ProductInterface
{
    /**
     * @return Product
     */
    protected function __load(eCurringClientInterface $client, string $id)
    {
        return $client->getProduct($id);
    }
}
