<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\Client\Factory;

use DateTime;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Factory\SubscriptionFactory;
use VladShut\eCurring\Resource\TransactionInterface;
use VladShut\eCurring\Tests\Unit\_helpers\AssertionTrait;
use VladShut\eCurring\Tests\Unit\_helpers\TestDataLoaderTrait;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class SubscriptionFactoryTest extends TestCase
{
    const ISO8601 = "Y-m-d\TH:i:sO" ;

    use TestDataLoaderTrait;
    use AssertionTrait;

    protected const TEST_FILES_DIR = __DIR__ . '/../../../files/UnitTests/Client/Factory/SubscriptionFactoryTest/';

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
        $factory = new SubscriptionFactory();

        $subscriptionPlan = $factory->fromData($this->client, $data['data']);

        self::assertEquals($data['data']['id'], $subscriptionPlan->getId());
        self::assertSame($data['data']['attributes']['mandate_code'], $subscriptionPlan->getMandate()->getCode());
        self::assertSame($data['data']['attributes']['mandate_accepted'], $subscriptionPlan->getMandate()->isAccepted());
        self::assertDateTimeOrNull($data['data']['attributes']['mandate_accepted_date'], $subscriptionPlan->getMandate()->getAcceptedDate());
        self::assertSame($data['data']['attributes']['start_date'], $subscriptionPlan->getStartDate()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['status'], $subscriptionPlan->getStatus()->getValue());
        self::assertSame($data['data']['attributes']['confirmation_page'], $subscriptionPlan->getConfirmationPage());
        self::assertSame($data['data']['attributes']['confirmation_sent'], $subscriptionPlan->isConfirmationSent());
        self::assertSame($data['data']['attributes']['subscription_webhook_url'], $subscriptionPlan->getSubscriptionWebhookUrl());
        self::assertSame($data['data']['attributes']['transaction_webhook_url'], $subscriptionPlan->getTransactionWebhookUrl());
        self::assertSame($data['data']['attributes']['success_redirect_url'], $subscriptionPlan->getSuccessRedirectUrl());
        self::assertSame($data['data']['relationships']['subscription-plan']['data']['id'], $subscriptionPlan->getSubscriptionPlan()->getId());
        self::assertSame($data['data']['relationships']['customer']['data']['id'], $subscriptionPlan->getCustomer()->getId());
        self::assertSame($data['data']['attributes']['created_at'], $subscriptionPlan->getCreatedAt()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['updated_at'], $subscriptionPlan->getUpdatedAt()->format(DateTime::ATOM));
        self::assertDateTimeOrNull($data['data']['attributes']['cancel_date'], $subscriptionPlan->getCancelDate());
        self::assertDateTimeOrNull($data['data']['attributes']['resume_date'], $subscriptionPlan->getResumeDate());

        self::assertTransactions($data['data'], ...$subscriptionPlan->getTransactions());
    }


    private static function assertTransactions($data, TransactionInterface ...$transactions): void
    {
        foreach ($transactions as $index => $transaction) {
            self::assertSame($data['relationships']['transactions']['data'][$index]['id'], $transaction->getId());
        }
    }

    public function getTransactionData(): array
    {
        return [
            [$this->getDataFromFile('subscription.json')],
            [$this->getDataFromFile('subscription_mandate_is_not_accepted.json')],
        ];
    }
}
