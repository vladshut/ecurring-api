<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use VladShut\eCurring\Resource\Curser\Pagination;

final class CustomerCollection extends Cursor
{
    protected function getPageData(int $pageNumber, int $itemsPerPage): Cursor
    {
        return $this->client->getCustomers(new Pagination($itemsPerPage, $pageNumber));
    }
}
