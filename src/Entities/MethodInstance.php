<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Entities;

/**
 * Класс MethodInstance сущность метода
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Entities
 * @version 2.0.0
 */
class MethodInstance
{
    /**
     * Метод всегда должен получать название и список аргументов
     *
     * @method __construct
     * @param string $name Название описываемого метода
     * @param Lotos\DI\Repository\Entities\ArgumentsCollection $arguments Коллекция аргументов
     */
    public function __construct(
        private string $name,
        private ArgumentsCollection $arguments)
    {
    }

    /**
     * Метод getName возвращает название описываемого метода
     *
     * @method getName
     * @return string Название создавемого метода
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Метод getArguments возвращает коллекцию аргументов метода
     *
     * @method getArguments
     * @return Lotos\DI\Repository\Entities\ArgumentsCollection Коллекция аргументов
     */
    public function getArguments() : ArgumentsCollection
    {
        return $this->arguments;
    }
}
