<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Subscription;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self active()
 * @method bool isActive()
 * @method static self cancelled()
 * @method bool isCancelled()
 * @method static self paused()
 * @method bool isPaused()
 * @method static self unverified()
 * @method bool isUnverified()
 */
final class Status extends AbstractEnum
{
    private const ACTIVE = 'active';
    private const CANCELLED = 'cancelled';
    private const PAUSED = 'paused';
    private const UNVERIFIED = 'unverified';
    private const SUSPENDED = 'suspended';
}
