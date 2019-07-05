<?php


namespace VladShut\eCurring\Tests\Features;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use VladShut\eCurring\Http\Endpoint\Exception\EndpointCouldNotBeMappedException;
use VladShut\eCurring\Http\Endpoint\MapperInterface;
use VladShut\eCurring\Http\Endpoint\Production;

class GetTransactionTest extends TestCase
{
    /**
     * @throws EndpointCouldNotBeMappedException
     */
    public function testGetTransaction()
    {
        $production = new Production();
        $id = Uuid::uuid4()->toString();

        $url = $production->map(MapperInterface::GET_TRANSACTION, [$id]);

        $this->assertEquals(Production::BASE_URL . '/transactions/' . $id, $url);
    }
}
