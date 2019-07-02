<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use VladShut\eCurring\Resource\Curser\Pagination;

/**
 * @method Subscription[] getAll()
 * @method Subscription current()
 */
final class SubscriptionCollection extends Cursor
{
    protected function getPageData(int $pageNumber, int $itemsPerPage): Cursor
    {
        return $this->client->getSubscriptions(new Pagination($itemsPerPage, $pageNumber));
    }
}
