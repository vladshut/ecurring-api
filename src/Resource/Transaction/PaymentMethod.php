<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Transaction;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self directDebit()
 * @method bool isDirectDebit()
 * @method static self creditcard()
 * @method bool isCreditcard()
 */
final class PaymentMethod extends AbstractEnum
{
    private const DIRECT_DEBIT = 'directdebit';
    private const CREDITCARD = 'creditcard';
}
