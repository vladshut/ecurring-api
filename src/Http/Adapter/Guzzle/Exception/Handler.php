<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Adapter\Guzzle\Exception;

use GuzzleHttp\Exception\RequestException;
use VladShut\eCurring\Exception\eCurringException;

final class Handler
{
    /**
     * @throws eCurringException
     * @throws NotFoundException
     */
    public static function handleRequestException(RequestException $exception): void
    {
        switch ($exception->getCode()) {
            case 400:
                throw new BadRequestException();
            case 404:
                throw new NotFoundException();
        }

        throw new eCurringException($exception->getMessage(), $exception->getCode(), $exception);
    }
}
