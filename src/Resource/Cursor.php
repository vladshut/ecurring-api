<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use Iterator;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Exception\NonExistentPageNumberException;

abstract class Cursor implements Iterator
{
    /**
     * @var eCurringClientInterface
     */
    protected $client;

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var int
     */
    private $position;

    /**
     * @var Customer[]|Subscription[]|Product[]|Transaction[]
     */
    private $objects;

    /**
     * @var bool
     *
     * Automatically load next pages when iterating over objects
     */
    private $autoload;

    /**
     * @var int
     */
    private $itemsPerPage;

    public function __construct(
        eCurringClientInterface $client,
        int $currentPage,
        int $totalPages,
        array $objects,
        ?int $itemsPerPage = 10,
        ?bool $autoload = true
    ) {
        $this->client = $client;
        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->position = 0;
        $this->objects = $objects;
        $this->itemsPerPage = $itemsPerPage;
        $this->autoload = $autoload;
    }

    public function getAll()
    {
        return $this->objects;
    }

    public function current()
    {
        return $this->objects[$this->position];
    }

    public function next(): void
    {
        ++$this->position;

        if (!$this->valid() && $this->autoload) {
            $this->nextPage();
        }
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->objects[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function disableAutoload(): void
    {
        $this->autoload = false;
    }

    public function enableAutoload(): void
    {
        $this->autoload = true;
    }

    /**
     * @throws NonExistentPageNumberException
     */
    public function firstPage(): void
    {
        $this->loadPage(0, $this->itemsPerPage);
    }

    /**
     * @throws NonExistentPageNumberException
     */
    public function nextPage(): void
    {
        $pageNumber = $this->currentPage +1;
        if ($pageNumber >= $this->totalPages) {
            $this->loadPage($pageNumber, $this->itemsPerPage);
        }
    }

    /**
     * @throws NonExistentPageNumberException
     */
    public function previousPage(): void
    {
        $pageNumber = $this->currentPage -1;
        if ($pageNumber < 0) {
            $this->loadPage($pageNumber, $this->itemsPerPage);
        }
    }

    /**
     * @throws NonExistentPageNumberException
     */
    public function goToPage(int $pageNumber): void
    {
        if ($pageNumber < 0 && $pageNumber >= $this->totalPages) {
            $this->loadPage($pageNumber, $this->itemsPerPage);
        } else {
            throw new NonExistentPageNumberException(sprintf('Page number #%s is invalid', $pageNumber));
        }
    }

    /**
     * @throws NonExistentPageNumberException
     */
    public function lastPage(): void
    {
        $this->loadPage($this->totalPages, $this->itemsPerPage);
    }

    /**
     * @throws NonExistentPageNumberException
     */
    private function loadPage(int $pageNumber, int $itemsPerPage): void
    {
        $this->objects = $this->getPageData($pageNumber, $itemsPerPage)->getAll();
        $this->position = 0;
        $this->currentPage = $pageNumber;
    }

    abstract protected function getPageData(int $pageNumber, int $itemsPerPage): self;
}
