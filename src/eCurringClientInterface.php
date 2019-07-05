<?php

declare(strict_types=1);

namespace VladShut\eCurring;

use VladShut\eCurring\Http\Resource\Creatable;
use VladShut\eCurring\Http\Resource\Deletable;
use VladShut\eCurring\Http\Resource\Updatable;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\CustomerCollection;
use VladShut\eCurring\Resource\Product;
use VladShut\eCurring\Resource\ProductCollection;
use VladShut\eCurring\Resource\Subscription;
use VladShut\eCurring\Resource\SubscriptionCollection;
use VladShut\eCurring\Resource\Transaction;
use VladShut\eCurring\Resource\TransactionCollection;
use Ramsey\Uuid\UuidInterface;

interface eCurringClientInterface
{

    /**
     * @return Customer|Subscription|Transaction
     */
    public function create(Creatable $entity): Creatable;

    /**
     * @return Customer|Subscription
     */
    public function update(Updatable $entity): Updatable;

    public function delete(Deletable $entity): void;

    /**
     * @return Customer[]
     */
    public function getCustomers(?Pagination $pagination = null): CustomerCollection;

    public function getCustomer(string $id): Customer;

    /**
     * @return Product[]
     */
    public function getProducts(?Pagination $pagination = null): ProductCollection;

    public function getProduct(string $id): Product;

    /**
     * @return Subscription[]
     */
    public function getSubscriptions(?Pagination $page = null): SubscriptionCollection;

    public function getSubscription(string $id, array $include = null): Subscription;

    /**
     * @return Transaction[]
     */
    public function getSubscriptionTransactions(Subscription $subscription, ?Pagination $pagination = null): TransactionCollection;

    public function getTransaction(UuidInterface $id): Transaction;
}
