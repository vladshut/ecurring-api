<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Adapter\Guzzle;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\RequestException;
use VladShut\eCurring\Exception\eCurringException;
use VladShut\eCurring\Http\Adapter\Guzzle\Exception\Handler;
use VladShut\eCurring\Http\Adapter\Guzzle\Exception\NotFoundException;
use VladShut\eCurring\Http\ClientInterface;
use VladShut\eCurring\Http\Endpoint\Exception\EndpointCouldNotBeMappedException;
use VladShut\eCurring\Http\Endpoint\MapperInterface;
use VladShut\eCurring\Http\Exception\ApiCallException;
use VladShut\eCurring\Resource\Curser\Pagination;
use Psr\Http\Message\ResponseInterface;

final class Client implements ClientInterface
{
    /**
     * @var GuzzleClientInterface
     */
    private $guzzleClient;

    /**
     * @var MapperInterface
     */
    private $endpointMapper;

    public function __construct(
        GuzzleClientInterface $guzzleClient,
        MapperInterface $urlMapper
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->endpointMapper = $urlMapper;
    }

    /**
     * @throws EndpointCouldNotBeMappedException
     * @throws eCurringException
     * @throws NotFoundException
     */
    public function getEndpoint(string $endpoint, ?array $urlBits = [], ?Pagination $page = null): ResponseInterface
    {
        $options = $page ? ['query' => $page->getQueryOptions()] : [];

        return $this->get(
            $this->endpointMapper->map($endpoint, $urlBits),
            $options
        );
    }

    /**
     * @throws eCurringException
     * @throws NotFoundException
     * @return ResponseInterface
     */
    public function getUrl(string $url): ResponseInterface
    {
        return $this->get($url);
    }

    public function getJson(ResponseInterface $response): string
    {
        return (string) $response->getBody();
    }

    /**
     * @throws NotFoundException
     * @throws eCurringException
     */
    private function get(string $url, ?array $options = []): ResponseInterface
    {
        try {
            $response = $this->guzzleClient->get($url, $options);

            $this->wasSuccessfulRequest($response);

            return $response;
        } catch (RequestException $exception) {
            Handler::handleRequestException($exception);
        }
    }

    /**
     * @throws eCurringException
     */
    public function postEndpoint(string $endpoint, array $data, array $urlBits = null): ResponseInterface
    {
        return $this->post(
            $this->endpointMapper->map($endpoint, $urlBits),
            ['json' => $data]
        );
    }

    /**
     * @throws ApiCallException
     * @throws eCurringException
     * @throws NotFoundException
     */
    private function post(string $url, ?array $options = []): ResponseInterface
    {
        try {
            $response = $this->guzzleClient->post($url, $options);
            $this->wasSuccessfulRequest($response);

            return $response;
        } catch (RequestException $exception) {
            Handler::handleRequestException($exception);
        }
    }

    /**
     * @throws eCurringException
     */
    public function patchEndpoint(string $endpoint, array $data, array $urlBits = null): ResponseInterface
    {
        return $this->patch(
            $this->endpointMapper->map($endpoint, $urlBits),
            ['json' => $data]
        );
    }

    /**
     * @throws ApiCallException
     * @throws eCurringException
     * @throws NotFoundException
     */
    private function patch(string $url, ?array $options = []): ResponseInterface
    {
        try {
            $response = $this->guzzleClient->patch($url, $options);
            $this->wasSuccessfulRequest($response);

            return $response;
        } catch (RequestException $exception) {
            Handler::handleRequestException($exception);
        }
    }

    /**
     * @throws eCurringException
     */
    public function deleteEndpoint(string $endpoint, array $data, array $urlBits = null): void
    {
        $this->delete(
            $this->endpointMapper->map($endpoint, $urlBits),
            ['json' => $data]
        );
    }

    /**
     * @throws ApiCallException
     * @throws eCurringException
     * @throws NotFoundException
     */
    private function delete(string $url, ?array $options = []): ResponseInterface
    {
        try {
            $response = $this->guzzleClient->delete($url, $options);
            $this->wasSuccessfulRequest($response);

            return $response;
        } catch (RequestException $exception) {
            Handler::handleRequestException($exception);
        }
    }

    /**
     * @throws ApiCallException
     */
    private function wasSuccessfulRequest(ResponseInterface $response): void
    {
        switch ($response->getStatusCode()) {
            case 200:
                return;

                break;
            case 201:
                return;

                break;
            default:
                throw new ApiCallException(
                    sprintf(
                        '%s %s: %s',
                        $response->getStatusCode(),
                        $response->getReasonPhrase(),
                        $response->getBody()->getContents()
                    )
                );
        }
    }
}
