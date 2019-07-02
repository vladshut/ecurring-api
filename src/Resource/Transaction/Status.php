<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Transaction;

use Werkspot\Enum\AbstractEnum;

/**
 * @method static self scheduled()
 * @method bool isScheduled()
 * @method static self succeeded()
 * @method bool isSucceeded()
 * @method static self fulfilled()
 * @method bool isFulfilled()
 * @method static self chargedBack()
 * @method bool isChargedBack()
 * @method static self rescheduled()
 * @method bool isRescheduled()
 * @method static self failed()
 * @method bool isFailed()
 * @method static self paymentReminderScheduled()
 * @method bool isPaymentReminderScheduled()
 * @method static self paymentReminderSent()
 * @method bool isPaymentReminderSent()
 * @method static self paymentReminderOverdue()
 * @method bool isPaymentReminderOverdue()
 */
final class Status extends AbstractEnum
{
    /**
     * The transaction is currently scheduled and will be executed on
     * it's due_date.
     */
    private const SCHEDULED = 'scheduled';

    /**
     * The transaction has succesfully been sent to the payment provider
     * and is awaiting fulfillment.
     */
    private const SUCCEEDED = 'succeeded';

    /**
     * The transaction has been fulfilled.
     * It is still possible for the transaction to be charged back due to
     * insufficient funds or manual client action.
     */
    private const FULFILLED = 'fulfilled';

    /**
     * The transaction was charged back.
     * In most cases a reason and reason_code will be provided to indicate
     * the cause of the charge back.
     */
    private const CHARGED_BACK = 'charged_back';

    /**
     * The transaction was rescheduled after a charge back.
     * A new due date is provided in the new_due_date attribute to indicate
     * when the next collection attempt will take place.
     * Generally this will take place 3 days after the charge back date.
     */
    private const RESCHEDULED = 'rescheduled';

    /**
     * The transaction was not accepted by the payment provider
     * In many cases this is because of a invalid IBAN.
     * The transaction will usually continue to fail until the problem is resolved.
     */
    private const FAILED = 'failed';

    /**
     * A payment reminder is scheduled to be sent for this transaction.
     * This means the transaction has failed and payment reminders are
     * enabled on the subscription plan.
     */
    private const PAYMENT_REMINDER_SCHEDULED = 'payment_reminder_scheduled';

    /**
     * A payment reminder was sent to the customer for this transaction.
     */
    private const PAYMENT_REMINDER_SENT = 'payment_reminder_sent';

    /**
     * All payment reminders have been sent and have remained unpaid.
     * All reminders expire after a certain time.
     * Once the last reminder has expired the transaction will be set to this status.
     */
    private const PAYMENT_REMINDER_OVERDUE = 'payment_reminder_overdue';
}
