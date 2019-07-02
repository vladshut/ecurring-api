<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Customer;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self male()
 * @method bool isMale()
 * @method static self female()
 * @method bool isFemale()
 */
final class Gender extends AbstractEnum
{
    private const MALE = 'm';
    private const FEMALE = 'f';
}
