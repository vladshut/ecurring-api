<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Curser;

use VladShut\eCurring\Resource\Exception\NonExistentPageNumberException;

final class Pagination
{
    /**
     * @var int
     */
    private $size;

    /**
     * @var int
     */
    private $number;

    /**
     * @throws NonExistentPageNumberException
     */
    public function __construct(int $size, ?int $page = 1)
    {
        if ($page < 1) {
            throw new NonExistentPageNumberException('Page number can not be lower than 1');
        }

        $this->size = $size;
        $this->number = $page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getQueryOptions(): array
    {
        return [
            'page' => [
                'number' => $this->number,
                'size' => $this->size,
            ]
        ];
    }
}
