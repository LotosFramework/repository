<?php

declare(strict_types=1);

namespace LotosTest\DI;

use PHPUnit\Framework\TestCase;

use Lotos\DI\Repository\Factories\DefinitionFactory;
use Lotos\DI\Repository\Entities\Definition;

use Lotos\Collection\CollectionFactory;

class DefinitionFactoryTest extends TestCase
{
 /**
     * @test
     * @requires PHP >= 8.0
     * @covers DefinitionFactory::createMethod
     */
    public function createMethod() : void
    {
        $this->assertInstanceOf(
            Definition::class,
            DefinitionFactory::createDefinition(
                CollectionFactory::createCollection(),
                CollectionFactory::createCollection()
            ),
            'Не удалось получить класс Definition из фабрики'
        );
    }
}
