<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Factories;

use Lotos\DI\Repository\Entities\{ArgumentsCollection, MethodInstance};

/**
 * Класс MethodFactory можно использовать для удобного получения метода
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Factories
 * @version 2.0.0
 */
class MethodFactory
{
    /**
     * Метод createMethod создает экземпляр объекта метода
     *
     * Метод всегда должен принимать название и список аргументов
     *
     * @method createMethod
     * @param string $method
     * @param Lotos\DI\Repository\Entities\ArgumentsCollection $arguments
     * @return Lotos\DI\Repository\Entities\MethodInstance
     */
    public static function createMethod(string $method, ArgumentsCollection $arguments) : MethodInstance
    {
        return new MethodInstance(
            name: $method,
            arguments: $arguments
        );
    }
}
