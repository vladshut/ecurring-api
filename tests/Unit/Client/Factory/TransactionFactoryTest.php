<?php

declare(strict_types=1);

namespace VladShut\eCurring\Tests\Unit\Client\Factory;

use DateTime;
use VladShut\eCurring\Resource\Factory\Transaction\EventFactoryInterface;
use VladShut\eCurring\Resource\Factory\TransactionFactory;
use VladShut\eCurring\Tests\Unit\_helpers\AssertionTrait;
use VladShut\eCurring\Tests\Unit\_helpers\TestDataLoaderTrait;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

final class TransactionFactoryTest extends TestCase
{
    const ISO8601 = "Y-m-d\TH:i:sO" ;

    use TestDataLoaderTrait;
    use AssertionTrait;

    protected const TEST_FILES_DIR = __DIR__ . '/../../../files/UnitTests/Client/Factory/TransactionFactoryTest/';

    /**
     * @var EventFactoryInterface|MockInterface
     */
    private $eventFactory;

    protected function setUp(): void
    {
        $this->eventFactory = Mockery::mock(EventFactoryInterface::class);
    }

    /**
     * @test
     * @dataProvider getTransactionData
     */
    public function fromData(array $data): void
    {
        $factory = new TransactionFactory($this->eventFactory);

        $this->eventFactory
            ->shouldReceive('fromArray')
            ->with($data['data']['attributes']['history'])
            ->andReturn([]);

        $structure = $factory->fromData($data['data']);

        self::assertSame($data['data']['id'], $structure->getId()->toString());
        self::assertSame($data['data']['attributes']['status'], $structure->getStatus()->getValue());
        self::assertSame($data['data']['attributes']['scheduled_on'], $structure->getScheduledOn()->format(DateTime::ATOM));
        self::assertEquals($data['data']['attributes']['amount'], $structure->getAmount()->getAmount()/100);
        self::assertDateTimeOrNull($data['data']['attributes']['due_date'], $structure->getDueDate());
        self::assertDateTimeOrNull($data['data']['attributes']['canceled_on'], $structure->getCanceledOn());
        self::assertStringOrNull($data['data']['attributes']['webhook_url'], $structure->getWebhookUrl());
        self::assertSame($data['data']['attributes']['payment_method'], $structure->getPaymentMethod()->getValue());

        self::assertSame([], $structure->getHistory());
    }

    public function getTransactionData(): array
    {
        return [
            'transaction' => [$this->getDataFromFile('transaction.json')],
        ];
    }
}
