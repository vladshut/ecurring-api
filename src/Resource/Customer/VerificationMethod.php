<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Customer;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self creditcard()
 * @method bool isCreditcard()
 * @method static self mistercash()
 * @method bool isMistercash()
 * @method static self ideal()
 * @method bool isIdeal()
 * @method static self kbc()
 * @method bool isKbc()
 * @method static self belfius()
 * @method bool isBelfius()
 */
final class VerificationMethod extends AbstractEnum
{
    private const CREDITCARD = 'creditcard';
    private const MISTERCASH = 'mistercash';
    private const IDEAL = 'ideal';
    private const KBC = 'kbc';
    private const BELFIUS = 'belfius';
}
