<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource\Subscription;

use DateTimeImmutable;
use VladShut\eCurring\Resource\Subscription\Exception\MandateAlreadyAcceptedException;
use VladShut\eCurring\Resource\Subscription\Exception\MandateInvalidException;

final class Mandate
{
    /**
     * @var string
     *
     * The unique mandate code which is generated when creating a subscription.
     */
    private $code;

    /**
     * @var bool
     *
     * Indicates whether the mandate has been accepted.
     * A mandate can be accepted by the customer or automatically by using the API.
     */
    private $accepted;

    /**
     * @var DateTimeImmutable|null
     *
     * The date on which the mandate has been accepted.
     */
    private $acceptedDate;

    /**
     * @throws MandateInvalidException
     */
    public function __construct(
        string $code,
        ?bool $accepted = false,
        ?DateTimeImmutable $acceptedDate = null
    ) {
        $this->code = $code;
        $this->accepted = $accepted;
        $this->acceptedDate = $acceptedDate;

        $this->validate();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function getAcceptedDate(): ?DateTimeImmutable
    {
        return $this->acceptedDate;
    }

    /**
     * @throws MandateAlreadyAcceptedException
     */
    public function accept(DateTimeImmutable $acceptedDate): void
    {
        if ($this->accepted === true) {
            throw new MandateAlreadyAcceptedException(
                sprintf('Mandate already accepted on %s', $this->acceptedDate->format('Y-m-d H:i:s'))
            );
        }

        $this->accepted = true;
        $this->acceptedDate = $acceptedDate;
    }

    /**
     * @throws MandateInvalidException
     */
    private function validate(): void
    {
        if ($this->accepted && $this->getAcceptedDate() === null) {
            throw new MandateInvalidException('No AcceptedDate provided although the mandate is accepted.');
        }
    }
}
