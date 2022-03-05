<?php

declare(strict_types=1);

namespace LotosTest\DI;

use PHPUnit\Framework\TestCase;
use Lotos\DI\Repository\Factories\ArgumentsCollectionFactory;
use Lotos\DI\Repository\Entitites\ArgumentsCollection;

class ArgumentsCollectionFactoryTest extends TestCase
{
    /**
     * @test
     * @requires PHP >= 8.0
     * @covers ArgumentsCollectionFactory::createCollection()
     */
    public function createCollection() : void
    {
        $this->assertInstanceOf(
            ArgumentsCollection::class,
            ArgumentsCollectionFactory::createCollection(),
            'Не удалось получить класс ArgumentsCollection из фабрики'
        );
    }

}
