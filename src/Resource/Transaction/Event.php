<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Transaction;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Transaction\Event\ReasonCode;

final class Event
{
    /**
     * @var int
     *
     * The current collection attempt.
     * Starts at 1 and will be increased after every re-schedule.
     */
    private $attempt;
    /**
     * @var DateTimeImmutable
     *
     * The date and time on which this event was record.
     */
    private $recordedOn;

    /**
     * @var Status
     *
     * The status of the transaction at this point in time.
     */
    private $status;

    /**
     * @var DateTimeImmutable|null
     *
     * This contains the new due date in this point in time when a transaction is rescheduled.
     * Only available when $status is 'rescheduled'
     */
    private $newDueDate;


    /**
     * @var string|null
     *
     * The charge back or failure reason.
     * Only provided when the status is 'charged_back' or 'failed'
     */
    private $reason;

    /**
     * @var ReasonCode|null
     *
     * The SEPA charge back or failure reason code.
     * Only provided when the status is 'charged_back' or 'failed'
     */
    private $reasonCode;

    public function __construct(
        int $attempt,
        DateTimeImmutable $recordedOn,
        Status $status,
        ?DateTimeImmutable $newDueDate,
        ?string $reason,
        ?ReasonCode $reasonCode
    ) {
        $this->attempt = $attempt;
        $this->reason = $reason;
        $this->status = $status;
        $this->newDueDate = $newDueDate;
        $this->reasonCode = $reasonCode;
        $this->recordedOn = $recordedOn;
    }

    public function getAttempt(): int
    {
        return $this->attempt;
    }

    public function getRecordedOn(): DateTimeImmutable
    {
        return $this->recordedOn;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getNewDueDate(): ?DateTimeImmutable
    {
        return $this->newDueDate;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function getReasonCode(): ?ReasonCode
    {
        return $this->reasonCode;
    }
}
