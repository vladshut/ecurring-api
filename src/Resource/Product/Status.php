<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Product;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self active()
 * @method bool isActive()
 * @method static self inactive()
 * @method bool isInactive()
 */
final class Status extends AbstractEnum
{
    private const ACTIVE = 'active';
    private const INACTIVE = 'inactive';
}
