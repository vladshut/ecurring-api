<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\Client\Factory;

use DateTime;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Factory\ProductFactory;
use VladShut\eCurring\Resource\SubscriptionInterface;
use VladShut\eCurring\Tests\Unit\_helpers\AssertionTrait;
use VladShut\eCurring\Tests\Unit\_helpers\TestDataLoaderTrait;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class SubscriptionPlanFactoryTest extends TestCase
{
    const ISO8601 = "Y-m-d\TH:i:sO" ;

    use TestDataLoaderTrait;
    use AssertionTrait;

    protected const TEST_FILES_DIR = __DIR__ . '/../../../files/UnitTests/Client/Factory/SubscriptionPlanFactoryTest/';

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
        $factory = new ProductFactory();

        $subscriptionPlan = $factory->fromData($this->client, $data['data']);

        self::assertEquals($data['data']['id'], $subscriptionPlan->getId());
        self::assertSame($data['data']['attributes']['name'], $subscriptionPlan->getName());
        self::assertSame($data['data']['attributes']['description'], $subscriptionPlan->getDescription());
        self::assertSame($data['data']['attributes']['start_date'], $subscriptionPlan->getStartDate()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['status'], $subscriptionPlan->getStatus()->getValue());
        self::assertSame($data['data']['attributes']['mandate_authentication_method'], $subscriptionPlan->getMandateAuthenticationMethod()->getValue());
        self::assertSame($data['data']['attributes']['send_invoice'], $subscriptionPlan->isSendInvoice());
        self::assertSame($data['data']['attributes']['storno_retries'], $subscriptionPlan->getStornoRetries());
        self::assertSame($data['data']['attributes']['created_at'], $subscriptionPlan->getCreatedAt()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['updated_at'], $subscriptionPlan->getUpdatedAt()->format(DateTime::ATOM));

        self::assertSubscriptions($data['data'], ...$subscriptionPlan->getSubscriptions());
    }

    private static function assertSubscriptions($data, SubscriptionInterface ...$subscriptions)
    {
        foreach ($subscriptions as $index => $subscription) {
            self::assertSame($data['relationships']['subscriptions']['data'][$index]['id'], $subscription->getId());
        }
    }

    public function getTransactionData(): array
    {
        return [
            'subscription-plan' => [$this->getDataFromFile('subscription-plan.json')],
            'subscription-plan no-subscriptions-included' => [$this->getDataFromFile('subscription-plan-no-subscriptions-included.json')],
        ];
    }
}
