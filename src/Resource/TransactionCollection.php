<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;

/**
 * @method Transaction[] getAll()
 * @method Transaction current()
 */
final class TransactionCollection extends Cursor
{
    /**
     * @var Subscription
     */
    private $subscription;

    public function __construct(
        Subscription $subscription,
        eCurringClientInterface $client,
        int $currentPage,
        int $totalPages,
        array $objects,
        ?int $itemsPerPage = 10,
        ?bool $autoload = true
    ) {
        parent::__construct($client, $currentPage, $totalPages, $objects, $itemsPerPage, $autoload);

        $this->subscription = $subscription;
    }

    protected function getPageData(int $number, int $itemsPerPage): Cursor
    {
        return $this->client->getSubscriptionTransactions($this->subscription, new Pagination($itemsPerPage, $number));
    }
}
