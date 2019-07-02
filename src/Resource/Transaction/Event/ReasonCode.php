<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Transaction\Event;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self ac01()
 * @method bool isAc01()
 * @method static self ac04()
 * @method bool isAc04()
 * @method static self ac06()
 * @method bool isAc06()
 * @method static self ag01()
 * @method bool isAg01()
 * @method static self ag02()
 * @method bool isAg02()
 * @method static self am04()
 * @method bool isAm04()
 * @method static self am05()
 * @method bool isAm05()
 * @method static self be04()
 * @method bool isBe04()
 * @method static self md01()
 * @method bool isMd01()
 * @method static self md02()
 * @method bool isMd02()
 * @method static self ff01()
 * @method bool isFf01()
 * @method static self md06()
 * @method bool isMd06()
 * @method static self md07()
 * @method bool isMd07()
 * @method static self ms02()
 * @method bool isMs02()
 * @method static self rc01()
 * @method bool isRc01()
 * @method static self tm01()
 * @method bool isTm01()
 * @method static self sl01()
 * @method bool isSl01()
 * @method static self focr()
 * @method bool isFocr()
 * @method static self dupl()
 * @method bool isDupl()
 * @method static self tech()
 * @method bool isTech()
 * @method static self frad()
 * @method bool isFrad()
 * @method static self agnt()
 * @method bool isAgnt()
 * @method static self curr()
 * @method bool isCurr()
 * @method static self cust()
 * @method bool isCust()
 * @method static self cuta()
 * @method bool isCuta()
 * @method static self upay()
 * @method bool isUpay()
 * @method static self be05()
 * @method bool isBe05()
 * @method static self ac13()
 * @method bool isAc13()
 * @method static self ff05()
 * @method bool isFf05()
 * @method static self dnor()
 * @method bool isDnor()
 * @method static self cnor()
 * @method bool isCnor()
 * @method static self rr0104()
 * @method bool isRr0104()
*/
final class ReasonCode extends AbstractEnum
{
    /**
     * Incorrect Account Number
     */
    private const AC01 = 'AC01';

    /**
     * Closed Account Number
     */
    private const AC04 = 'AC04';

    /**
     * Blocked Account
     */
    private const AC06 = 'AC06';

    /**
     * Payment Type not allowed
     */
    private const AG01 = 'AG01';

    /**
     * Invalid Bank Operation Code
     */
    private const AG02 = 'AG02';

    /**
     * Insufficient Funds
     */
    private const AM04 = 'AM04';

    /**
     * Duplicate Collection / Entry
     */
    private const AM05 = 'AM05';

    /**
     * Missing Creditor Address
     */
    private const BE04 = 'BE04';

    /**
     * No Valid Mandate
     */
    private const MD01 = 'MD01';

    /**
     * Missing Mandatory Inform
     */
    private const MD02 = 'MD02';

    /**
     * Invalid File Format
     */
    private const FF01 = 'FF01';

    /**
     * Refund Request By End Customer
     */
    private const MD06 = 'MD06';

    /**
     * End Customer Deceased
     */
    private const MD07 = 'MD07';

    /**
     * Not Specified Reason by Customer
     */
    private const MS02 = 'MS02';

    /**
     * Invalid BIC
     */
    private const RC01 = 'RC01';

    /**
     * Cut-off Time
     */
    private const TM01 = 'TM01';

    /**
     * Specific Service offered debtor bank
     */
    private const SL01 = 'SL01';

    /**
     * Return due to a Recall
     */
    private const FOCR = 'FOCR';

    /**
     * Duplicate Payment
     */
    private const DUPL = 'DUPL';

    /**
     * Payment in Error (technical reason)
     */
    private const TECH = 'TECH';

    /**
     * Fraud
     */
    private const FRAD = 'FRAD';

    /**
     * Incorrect Agent
     */
    private const AGNT = 'AGNT';

    /**
     * Incorrect Currency
     */
    private const CURR = 'CURR';

    /**
     * Recall by Customer
     */
    private const CUST = 'CUST';

    /**
     * Recall due to Investigation Request
     */
    private const CUTA = 'CUTA';

    /**
     * Undue Payment
     */
    private const UPAY = 'UPAY';

    /**
     * Unrecognised Initiating Party
     */
    private const BE05 = 'BE05';

    /**
     * Invalid Debtor Account Type
     */
    private const AC13 = 'AC13';

    /**
     * Invalid Local Instrument Code
     */
    private const FF05 = 'FF05';

    /**
     * Debtor Bank is not Registered
     */
    private const DNOR = 'DNOR';

    /**
     * Creditor Bank is not Registered
     */
    private const CNOR = 'CNOR';

    /**
     * Regulatory Reason
     */
    private const RR01_04 = 'RR01-04';
}
