<?php

declare(strict_types=1);

namespace VladShut\eCurring\Http\Endpoint;

use VladShut\eCurring\Http\Endpoint\Exception\EndpointCouldNotBeMappedException;

interface MapperInterface
{
    public const GET_CUSTOMERS = 'get_customers';
    public const GET_CUSTOMER = 'get_customer';
    public const POST_CUSTOMER = 'post_customer';
    public const PATCH_CUSTOMER = 'patch_customer';

    public const GET_SUBSCRIPTION_PLANS = 'get_subscription_plans';
    public const GET_SUBSCRIPTION_PLAN = 'get_subscription_plan';

    public const GET_SUBSCRIPTIONS = 'get_subscriptions';
    public const GET_SUBSCRIPTION = 'get_subscription';
    public const POST_SUBSCRIPTION = 'post_subscription';
    public const PATCH_SUBSCRIPTION = 'patch_subscription';
    public const GET_SUBSCRIPTION_TRANSACTIONS = 'get_subscription_transactions';

    public const GET_TRANSACTION = 'get_transaction';
    public const POST_TRANSACTION = 'post_transaction';
    public const DELETE_TRANSACTION = 'delete_transactions';

    /**
     * @throws EndpointCouldNotBeMappedException
     */
    public function map(string $key, array $bits): string;
}
