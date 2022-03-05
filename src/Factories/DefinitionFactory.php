<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Factories;

use Lotos\Collection\Collection;
use Lotos\DI\Repository\Entities\Definition;

/**
 * Класс DefinitionFactory можно использовать для удобного получения Описания
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Factories
 * @version 2.0.0
 */
class DefinitionFactory
{
    /**
     * Метод createDefinition создает экземпляр объекта Описания
     *
     * Метод всегда должен принимать Коллекцию
     *
     * @method createDefinition
     * @param Lotos\Collection\Collection $collection
     * @return Lotos\DI\Repository\Entities\Definition
     */
    public static function createDefinition(Collection $collection) : Definition
    {
        return new Definition($collection->newInstance(), $collection->newInstance());
    }
}
