<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Factory;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Curser\Pagination;
use VladShut\eCurring\Resource\Product;
use VladShut\eCurring\Resource\ProductCollection;

interface ProductFactoryInterface
{
    public function fromData(eCurringClientInterface $client, array $data): Product;

    /**
     * @return Product[]
     */
    public function fromArray(eCurringClientInterface $client, array $data, Pagination $page): ProductCollection;
}
