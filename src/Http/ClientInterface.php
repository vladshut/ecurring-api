<?php

namespace VladShut\eCurring\Http;

use VladShut\eCurring\Http\Exception\ApiCallException;
use VladShut\eCurring\Resource\Curser\Pagination;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * @throws ApiCallException
     */
    public function getEndpoint(string $endpoint, ?array $urlBits = [], ?Pagination $page = null): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function getUrl(string $url): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function postEndpoint(string $endpoint, array $param, ?array $urlBits = []): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function patchEndpoint(string $endpoint, array $param, ?array $urlBits = []): ResponseInterface;

    /**
     * @throws ApiCallException
     */
    public function deleteEndpoint(string $endpoint, array $param, ?array $urlBits = []): void;

    public function getJson(ResponseInterface $response): string;
}
