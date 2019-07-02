<?php

declare(strict_types=1);

namespace VladShut\eCurring;

use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use VladShut\eCurring\Http\Adapter\Guzzle\Client as GuzzleClient;
use VladShut\eCurring\Http\ClientInterface;
use VladShut\eCurring\Http\Endpoint\Production;
use VladShut\eCurring\Http\Resource\CreateParser;
use VladShut\eCurring\Http\Resource\UpdateParser;
use VladShut\eCurring\Resource\Factory\CustomerFactory;
use VladShut\eCurring\Resource\Factory\ProductFactory;
use VladShut\eCurring\Resource\Factory\SubscriptionFactory;
use VladShut\eCurring\Resource\Factory\Transaction\EventFactory;
use VladShut\eCurring\Resource\Factory\TransactionFactory;
use Psr\Http\Message\RequestInterface;

final class eCurringClientFactory
{
    public static function create(string $apiKey): eCurringClient
    {
        return new eCurringClient(
            self::createHttpClient($apiKey),
            new CustomerFactory(),
            new SubscriptionFactory(),
            new ProductFactory(),
            new TransactionFactory(new EventFactory()),
            new CreateParser(),
            new UpdateParser()
        );
    }

    private static function createHttpClient(string $apiKey): ClientInterface
    {
        $handler = new HandlerStack();
        $handler->setHandler(new CurlHandler());

        $handler->push(Middleware::mapRequest(function (RequestInterface $request) use ($apiKey) {
            return $request->withHeader('X-Authorization', $apiKey);
        }));

        return new GuzzleClient(
            new \GuzzleHttp\Client(['handler' => $handler]),
            new Production()
        );
    }
}
