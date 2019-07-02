<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Proxy;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Subscription;

abstract class AbstractProxy
{
    /**
     * @var eCurringClientInterface
     */
    private $__client;

    /**
     * @var string
     */
    private $__id;

    /**
     * @var null|Subscription
     */
    private $__object;

    /**
     * @return SubscriptionProxy
     */
    public function __construct(eCurringClientInterface $client, $deviceId)
    {
        $this->__id = $deviceId;
        $this->__client = $client;
    }

    /**
     * @return Subscription
     */
    abstract protected function __load(eCurringClientInterface $client, string $id);

    public function getId()
    {
        return $this->__id;
    }

    public function __call($method, $args)
    {
        if (!$this->__object) {
            $this->__object = $this->__load($this->__client, $this->__id);
        }

        return call_user_func_array([$this->__object, $method], $args);
    }
}
