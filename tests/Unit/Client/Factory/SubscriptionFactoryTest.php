<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\Client\Factory;

use DateTime;
use VladShut\eCurring\eCurringClientInterface;
use VladShut\eCurring\Resource\Customer;
use VladShut\eCurring\Resource\Factory\CustomerFactory;
use VladShut\eCurring\Resource\Factory\ProductFactory;
use VladShut\eCurring\Resource\Factory\SubscriptionFactory;
use VladShut\eCurring\Resource\Factory\Transaction\EventFactory;
use VladShut\eCurring\Resource\Factory\TransactionFactory;
use VladShut\eCurring\Resource\Product;
use VladShut\eCurring\Resource\Transaction;
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
     * @dataProvider getSubscriptionData
     * @param array $data
     */
    public function fromData(array $data): void
    {
        $customerFactory = new CustomerFactory();
        $productFactory = new ProductFactory();
        $transactionFactory = new TransactionFactory(new EventFactory());

        $factory = new SubscriptionFactory($customerFactory, $productFactory, $transactionFactory);

        $subscription = $factory->fromData($this->client, $data['data'], $data['included']);

        self::assertEquals($data['data']['id'], $subscription->getId());
        self::assertSame($data['data']['attributes']['mandate_code'], $subscription->getMandate()->getCode());
        self::assertSame($data['data']['attributes']['mandate_accepted'], $subscription->getMandate()->isAccepted());
        self::assertDateTimeOrNull($data['data']['attributes']['mandate_accepted_date'], $subscription->getMandate()->getAcceptedDate());
        self::assertSame($data['data']['attributes']['start_date'], $subscription->getStartDate()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['status'], $subscription->getStatus()->getValue());
        self::assertSame($data['data']['attributes']['confirmation_page'], $subscription->getConfirmationPage());
        self::assertSame($data['data']['attributes']['confirmation_sent'], $subscription->isConfirmationSent());
        self::assertSame($data['data']['attributes']['subscription_webhook_url'], $subscription->getSubscriptionWebhookUrl());
        self::assertSame($data['data']['attributes']['transaction_webhook_url'], $subscription->getTransactionWebhookUrl());
        self::assertSame($data['data']['attributes']['success_redirect_url'], $subscription->getSuccessRedirectUrl());
        self::assertEquals($data['data']['relationships']['subscription-plan']['data']['id'], $subscription->getSubscriptionPlan()->getId());
        self::assertEquals($data['data']['relationships']['customer']['data']['id'], $subscription->getCustomer()->getId());
        self::assertSame($data['data']['attributes']['created_at'], $subscription->getCreatedAt()->format(DateTime::ATOM));
        self::assertSame($data['data']['attributes']['updated_at'], $subscription->getUpdatedAt()->format(DateTime::ATOM));
        self::assertDateTimeOrNull($data['data']['attributes']['cancel_date'], $subscription->getCancelDate());
        self::assertDateTimeOrNull($data['data']['attributes']['resume_date'], $subscription->getResumeDate());

        self::assertTransactions($data['data'], ...$subscription->getTransactions());

        self::assertInstanceOf(Customer::class, $subscription->getCustomer());
        self::assertInstanceOf(Product::class, $subscription->getSubscriptionPlan());
    }


    private static function assertTransactions($data, TransactionInterface ...$transactions): void
    {
        foreach ($transactions as $index => $transaction) {
            self::assertInstanceOf(Transaction::class, $transaction);
            self::assertEquals($data['relationships']['transactions']['data'][$index]['id'], $transaction->getId());
        }
    }

    public function getSubscriptionData(): array
    {
        return [
            [$this->getDataFromFile('subscription.json')],
            [$this->getDataFromFile('subscription_mandate_is_not_accepted.json')],
        ];
    }
}
