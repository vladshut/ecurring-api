<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Endpoint;

use Exception;
use VladShut\eCurring\Http\Endpoint\Exception\EndpointCouldNotBeMappedException;

final class Production implements MapperInterface
{
    public const BASE_URL = 'https://api.ecurring.com';


    public const GET_CUSTOMERS_ENDPOINT = '/customers';
    public const GET_CUSTOMER_ENDPOINT = '/customers/%s';
    public const POST_CUSTOMER_ENDPOINT = '/customers';
    public const PATCH_CUSTOMER_ENDPOINT = '/customers/%s';

    public const GET_SUBSCRIPTION_PLANS_ENDPOINT = '/subscription-plans';
    public const GET_SUBSCRIPTION_PLAN_ENDPOINT = '/subscription-plans/%s';

    public const GET_SUBSCRIPTIONS_ENDPOINT = '/subscriptions';
    public const GET_SUBSCRIPTION_ENDPOINT = '/subscriptions/%s';
    public const POST_SUBSCRIPTION_ENDPOINT = '/subscriptions';
    public const PATCH_SUBSCRIPTION_ENDPOINT = '/subscriptions/%s';
    public const GET_SUBSCRIPTION_TRANSACTIONS_ENDPOINT = 'subscriptions/%s/transactions';

    public const GET_TRANSACTION_ENDPOINT = '/transactions/%s';
    public const POST_TRANSACTION_ENDPOINT = '/transactions';
    public const DELETE_TRANSACTION_ENDPOINT = '/transactions/%s';

    private $map = [];

    public function __construct()
    {
        $this->map = [
            MapperInterface::GET_CUSTOMERS => self::BASE_URL . self::GET_CUSTOMERS_ENDPOINT,
            MapperInterface::GET_CUSTOMER => self::BASE_URL . self::GET_CUSTOMER_ENDPOINT,
            MapperInterface::POST_CUSTOMER => self::BASE_URL . self::POST_CUSTOMER_ENDPOINT,
            MapperInterface::PATCH_CUSTOMER => self::BASE_URL . self::PATCH_CUSTOMER_ENDPOINT,

            MapperInterface::GET_SUBSCRIPTION_PLANS => self::BASE_URL . self::GET_SUBSCRIPTION_PLANS_ENDPOINT,
            MapperInterface::GET_SUBSCRIPTION_PLAN => self::BASE_URL . self::GET_SUBSCRIPTION_PLAN_ENDPOINT,

            MapperInterface::GET_SUBSCRIPTIONS => self::BASE_URL . self::GET_SUBSCRIPTIONS_ENDPOINT,
            MapperInterface::GET_SUBSCRIPTION => self::BASE_URL . self::GET_SUBSCRIPTION_ENDPOINT,
            MapperInterface::POST_SUBSCRIPTION => self::BASE_URL . self::POST_SUBSCRIPTION_ENDPOINT,
            MapperInterface::PATCH_SUBSCRIPTION => self::BASE_URL . self::PATCH_SUBSCRIPTION_ENDPOINT,
            MapperInterface::GET_SUBSCRIPTION_TRANSACTIONS => self::BASE_URL . self::GET_SUBSCRIPTION_TRANSACTIONS_ENDPOINT,

            MapperInterface::GET_TRANSACTION => self::BASE_URL . self::GET_TRANSACTION_ENDPOINT,
            MapperInterface::POST_TRANSACTION => self::BASE_URL . self::POST_TRANSACTION_ENDPOINT,
            MapperInterface::DELETE_TRANSACTION => self::BASE_URL . self::DELETE_TRANSACTION_ENDPOINT,
        ];
    }

    public function map(string $key, ?array $bits = []): string
    {
        if (array_key_exists($key, $this->map)) {
            $url = $this->map[$key];
        } else {
            throw new EndpointCouldNotBeMappedException(sprintf('key \'%s\' could not be mapped to an URL', $key));
        }

        $bits = $bits ?? [];

        return sprintf($url, ...$bits);
    }
}
