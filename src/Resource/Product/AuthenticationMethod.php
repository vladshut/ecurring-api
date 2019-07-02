<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Product;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self email()
 * @method bool isEmail()
 * @method static self sms()
 * @method bool isSms()
 * @method static self ideal()
 * @method bool isIdeal()
 * @method static self onlinePayment()
 * @method bool isOnlinePayment()
 * @method static self firstPayment()
 * @method bool isFirstPayment()
 */
final class AuthenticationMethod extends AbstractEnum
{
    private const EMAIL = 'email';
    private const SMS = 'sms';
    private const IDEAL = 'ideal';
    private const ONLINE_PAYMENT = 'online_payment';
    private const FIRST_PAYMENT = 'first_payment';
}
