<?php

declare(strict_types=1);

namespace VladShut\eCurring\Resource;

use DateTimeImmutable;
use VladShut\eCurring\Http\Resource\Creatable;
use VladShut\eCurring\Http\Resource\Updatable;
use VladShut\eCurring\Resource\Customer\Gender;
use VladShut\eCurring\Resource\Customer\VerificationMethod;
use VladShut\eCurring\Resource\Transaction\PaymentMethod;

final class Customer implements CustomerInterface, Creatable, Updatable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Gender|null
     *
     * The gender of the customer.
     * Used to determine the salutation in communication with the customer. Possible values: m / f
     */
    private $gender;

    /**
     * @var string
     *
     * The first name of the customer
     */
    private $firstName;

    /**
     * @var string|null
     *
     * The middle name of the customer
     */
    private $middleName;

    /**
     * @var string
     *
     * The last name of the customer
     */
    private $lastName;

    /**
     * @var string|null
     *
     * The name of the company of the customer
     */
    private $companyName;

    /**
     * @var string|null
     *
     * The vat number of the company of the customer
     */
    private $vatNumber;

    /**
     * @var PaymentMethod
     *
     * The payment type used to collect the funds from the customer.
     */
    private $paymentType;

    /**
     * @var VerificationMethod|null
     *
     * The method used used by the customer to validate their bankaccount or creditcard.
     * Empty when IBAN is manually entered.
     */
    private $bankVerificationMethod;

    /**
     * @var string
     *
     * The name of the holder of the bank account or creditcard.
     * Replaces the deprecated bankHolder.
     */
    private $cardHolder;

    /**
     * @var string
     *
     * The last 4 digits of the bank account or creditcard of the client.
     */
    private $cardNumber;

    /**
     * @var string|null
     *
     * The postalcode of the address of the customer
     */
    private $postalcode;

    /**
     * @var string|null
     *
     * The house number of the address of the customer
     */
    private $houseNumber;

    /**
     * @var string|null
     *
     * The house number addition of the address of the customer
     */
    private $houseNumberAdd;

    /**
     * @var string|null
     *
     * The street of the address of the customer
     */
    private $street;

    /**
     * @var string|null
     *
     * The city of the address of the customer
     */
    private $city;

    /**
     * @var string|null
     *
     * The 2 letter ISO code of the country of residence of the customer
     */
    private $countryCode;

    /**
     * @var string|null
     *
     * The preferred communication language of the customer.
     * Any notifications sent to the customer will be in this language.
     * Possible values: nl / en.
     */
    private $language;

    /**
     * @var string
     *
     * The email address of the customer
     */
    private $email;

    /**
     * @var string|null
     *
     * The telephone number of the customer
     */
    private $telephone;

    /**
     * @var SubscriptionInterface[]
     *
     * The subscriptions of the customers
     */
    private $subscriptions;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the customer was created
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * The date on which the customer was last updated
     */
    private $updatedAt;

    private function __construct()
    {
    }

    public static function new(
        string $firstName,
        string $lastName,
        PaymentMethod $paymentType,
        string $cardHolder,
        string $cardNumber,
        string $email,
        ?Gender $gender = null,
        ?string $middleName = null,
        ?string $companyName = null,
        ?string $vatNumber = null,
        ?string $postalcode = null,
        ?string $houseNumber = null,
        ?string $houseNumberAdd = null,
        ?string $street = null,
        ?string $city = null,
        ?string $countryCode = null,
        ?string $language = null,
        ?string $telephone = null
    ): self {
        $self = new self();
        $self->gender = $gender;
        $self->firstName = $firstName;
        $self->lastName = $lastName;
        $self->paymentType = $paymentType;
        $self->cardHolder = $cardHolder;
        $self->cardNumber = $cardNumber;
        $self->email = $email;
        $self->middleName = $middleName;
        $self->companyName = $companyName;
        $self->vatNumber = $vatNumber;
        $self->postalcode = $postalcode;
        $self->houseNumber = $houseNumber;
        $self->houseNumberAdd = $houseNumberAdd;
        $self->street = $street;
        $self->city = $city;
        $self->countryCode = $countryCode;
        $self->language = $language;
        $self->telephone = $telephone;

        return $self;
    }

    public static function fromData(
        int $id,
        string $firstName,
        string $lastName,
        PaymentMethod $paymentType,
        string $email,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
        ?string $cardHolder,
        ?string $cardNumber,
        ?Gender $gender = null,
        ?string $middleName = null,
        ?string $companyName = null,
        ?string $vatNumber = null,
        ?string $postalcode = null,
        ?string $houseNumber = null,
        ?string $houseNumberAdd = null,
        ?string $street = null,
        ?string $city = null,
        ?string $countryCode = null,
        ?string $language = null,
        ?string $telephone = null,
        ?VerificationMethod $bankVerificationMethod = null,
        ?SubscriptionInterface ...$subscriptions
    ): self {
        $self = new self();
        $self->id = $id;
        $self->firstName = $firstName;
        $self->lastName = $lastName;
        $self->paymentType = $paymentType;
        $self->cardHolder = $cardHolder;
        $self->cardNumber = $cardNumber;
        $self->email = $email;
        $self->createdAt = $createdAt;
        $self->updatedAt = $updatedAt;
        $self->gender = $gender;
        $self->companyName = $companyName;
        $self->vatNumber = $vatNumber;
        $self->postalcode = $postalcode;
        $self->houseNumber = $houseNumber;
        $self->houseNumberAdd = $houseNumberAdd;
        $self->street = $street;
        $self->city = $city;
        $self->countryCode = $countryCode;
        $self->language = $language;
        $self->telephone = $telephone;
        $self->middleName = $middleName;
        $self->bankVerificationMethod = $bankVerificationMethod;
        $self->subscriptions = $subscriptions;

        return $self;
    }

    public function setGender(?Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function setVatNumber(?string $vatNumber): void
    {
        $this->vatNumber = $vatNumber;
    }

    public function setPaymentType(PaymentMethod $paymentType): void
    {
        $this->paymentType = $paymentType;
    }

    public function setBankVerificationMethod(?VerificationMethod $bankVerificationMethod): void
    {
        $this->bankVerificationMethod = $bankVerificationMethod;
    }

    public function setCardHolder(string $cardHolder): void
    {
        $this->cardHolder = $cardHolder;
    }

    public function setCardNumber(string $cardNumber): void
    {
        $this->cardNumber = $cardNumber;
    }

    public function setPostalcode(?string $postalcode): void
    {
        $this->postalcode = $postalcode;
    }

    public function setHouseNumber(?string $houseNumber): void
    {
        $this->houseNumber = $houseNumber;
    }

    public function setHouseNumberAdd(?string $houseNumberAdd): void
    {
        $this->houseNumberAdd = $houseNumberAdd;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function getPaymentType(): PaymentMethod
    {
        return $this->paymentType;
    }

    public function getBankVerificationMethod(): ?VerificationMethod
    {
        return $this->bankVerificationMethod;
    }

    public function getCardHolder(): string
    {
        return $this->cardHolder;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function getHouseNumberAdd(): ?string
    {
        return $this->houseNumberAdd;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @return SubscriptionInterface[]
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
