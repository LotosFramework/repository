<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Entities;

use Lotos\Collection\Collection;

/**
 * Класс ArgumentsCollection Коллекция аргументов сохраняемых методов
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Entities
 * @version 2.0.0
 */
class ArgumentsCollection extends Collection implements \Traversable
{
    /**
     * Конструктор принимает список сущностей, которые нужно сохранить в коллекцию
     *
     * @method __construct
     * @param array|null $entities Набор сущностей
     */
    public function __construct(?array $entities = null)
    {
        parent::__construct();
        if (!is_null($entities)) {
            $this->addValidElements($entities);
        }
    }

    /**
     * Метод push принимает аргументы, которые нужно добавить в коллекцию аргументов
     *
     * @method push
     * @param mixed ...$values
     * @return void
     *
     * @example push(['foo', 'bar', 'baz'])
     * @example push('foo', 'bar', 'baz')
     */
    public function push(...$values) : void
    {
        foreach($values as $element) {
            if(is_array($element)) {
                $this->addValidElements($element);
            } else {
                if (!($element instanceof ArgumentEntity)) {
                    throw new \InvalidArgumentException('Entity must be instance of ArgumentEntity');
                }
                $this->addValidElement($element);
            }
        }
    }

    /**
     * Метод addValidElement принимает аргумент, который нужно добавить в коллекцию аргументов
     *
     * @method addValidElement
     * @param Lotos\DI\Repository\Entities\ArgumentEntity Аргумент, который нужно записать
     * @return void
     */
    private function addValidElement(ArgumentEntity $element) : void
    {
        parent::push($element);
    }

    /**
     * Метод addValidElements массив аргументов, которые нужно добавить в коллекцию аргументов
     *
     * @method addValidElements
     * @param Lotos\DI\Repository\Entities\ArgumentEntity Аргумент, который нужно записать
     * @return void
     */
    private function addValidElements(array $entities) : void
    {
        foreach($entities as $entity) {
            if (!($entity instanceof ArgumentEntity)) {
                throw new \InvalidArgumentException('Entity must be instance of ArgumentEntity');
            } else {
                $this->addValidElement($entity);
            }
        }
    }
}
