<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\Client\Factory;

use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Customer\Gender;
use VladShut\eCurring\Resource\Customer\VerificationMethod;
use VladShut\eCurring\Resource\Factory\CustomerFactory;
use VladShut\eCurring\Resource\SubscriptionInterface;
use VladShut\eCurring\Tests\Unit\_helpers\AssertionTrait;
use VladShut\eCurring\Tests\Unit\_helpers\TestDataLoaderTrait;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class CustomerFactoryTest extends TestCase
{
    const ISO8601 = "Y-m-d\TH:i:sO" ;

    use TestDataLoaderTrait;
    use AssertionTrait;

    protected const TEST_FILES_DIR = __DIR__ . '/../../../files/UnitTests/Client/Factory/CustomerFactoryTest/';

    /**
     * @var eCurringClientInterface|MockInterface
     */
    private $client;

    protected function setUp(): void
    {
        $this->client = Mockery::mock(eCurringClientInterface::class);
    }

    /**
     * @test
     * @dataProvider getTransactionData
     */
    public function fromData(array $data): void
    {
        $factory = new CustomerFactory();

        $customer = $factory->fromData($this->client, $data['data']);

        self::assertEquals($data['data']['id'], $customer->getId());
        self::assertSame($data['data']['attributes']['first_name'], $customer->getFirstName());
        self::assertSame($data['data']['attributes']['last_name'], $customer->getLastName());
        self::assertSame($data['data']['attributes']['payment_method'], $customer->getPaymentType()->getValue());
        self::assertSame($data['data']['attributes']['card_holder'], $customer->getCardHolder());
        self::assertSame($data['data']['attributes']['card_number'], $customer->getCardNumber());
        self::assertSame($data['data']['attributes']['email'], $customer->getEmail());

        self::assertEnumOrNull($data['data']['attributes']['gender'], Gender::class, $customer->getGender());
        self::assertEquals($data['data']['attributes']['middle_name'], $customer->getMiddleName());
        self::assertEquals($data['data']['attributes']['company_name'], $customer->getCompanyName());
        self::assertEquals($data['data']['attributes']['vat_number'], $customer->getVatNumber());
        self::assertEquals($data['data']['attributes']['postalcode'], $customer->getPostalcode());
        self::assertEquals($data['data']['attributes']['house_number'], $customer->getHouseNumber());
        self::assertEquals($data['data']['attributes']['house_number_add'], $customer->getHouseNumberAdd());
        self::assertEquals($data['data']['attributes']['street'], $customer->getStreet());
        self::assertEquals($data['data']['attributes']['city'], $customer->getCity());
        self::assertEquals($data['data']['attributes']['country_iso2'], $customer->getCountryCode());
        self::assertEquals($data['data']['attributes']['language'], $customer->getLanguage());
        self::assertEquals($data['data']['attributes']['telephone'], $customer->getTelephone());
        self::assertEnumOrNull($data['data']['attributes']['bank_verification_method'], VerificationMethod::class, $customer->getBankVerificationMethod());

        self::assertSubscriptions($data['data'], ...$customer->getSubscriptions());
    }

    private static function assertSubscriptions($data, SubscriptionInterface ...$subscriptions): void
    {
        foreach ($subscriptions as $index => $subscription) {
            self::assertSame($data['relationships']['subscriptions']['data'][$index]['id'], $subscription->getId());
        }
    }

    public function getTransactionData(): array
    {
        return [
            'customer' => [$this->getDataFromFile('customer.json')],
        ];
    }
}
