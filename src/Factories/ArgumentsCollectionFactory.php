<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Factories;

use Lotos\DI\Repository\Entities\ArgumentsCollection;
/**
 * Класс ArgumentsCollectionFactory можно использовать для удобного получения Коллекции аргументов
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Factories
 * @version 2.0.0
 */
class ArgumentsCollectionFactory
{
    /**
     * Метод createCollection создает коллекцию аргументов
     *
     * @method createCollection
     * @param array|null $arguments Список аргументов, которые нужно сохранить
     * @return Lotos\DI\Repository\Entities\ArgumentsCollection
     */
    public static function createCollection(?array $arguments = null) : ArgumentsCollection
    {
        return new ArgumentsCollection($arguments);
    }
}
