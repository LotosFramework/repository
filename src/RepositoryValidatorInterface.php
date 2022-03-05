<?php

declare(strict_types=1);

namespace Lotos\DI\Repository;

use Lotos\Collection\Collection as CollectionInterface;

/**
 * Интерфейс RepositoryValidatorInterface
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository
 * @version 2.0.0
 */
interface RepositoryValidatorInterface
{

    /**
     * Метод ensureUniqueClass проверяет что сохраняемый класс уникален
     *
     * @method ensureUniqueClass
     * @param Lotos\Collection\Collection $repository
     * @param string $class
     * @throws Lotos\DI\Repository\Exception\SaveAlreadySavedClass
     * @return void
     */
    public function ensureUniqueClass(Collection $repository, string $class) : void;

    /**
     * Метод ensureUniqueInterface проверяет что сохраняемый интерфейс уникален
     *
     * @method ensureUniqueInterface
     * @param Lotos\Collection\Collection $repository
     * @param string $interface
     * @throws Lotos\DI\Repository\Exception\SaveAlreadySavedInterface
     * @return void
     */
    public function ensureUniqueInterface(Collection $repository, string $interface) : void;

    /**
     * Метод ensureInstantiable проверяет что сохраняется именно класс
     *
     * @method ensureInstantiable
     * @param string $class
     * @throws Lotos\DI\Repository\Exception\WrongArgumentTypeException
     * @return void
     */
    public function ensureInstantiable(string $class) : void;

    /**
     * Метод ensureValidInterface проверяет что передан действительно интерфейс
     *
     * @method ensureValidInterface
     * @param string $interface
     * @throws Lotos\DI\Repository\Exception\WrongArgumentTypeException
     * @return void
     */
    public function ensureValidInterface(string $interface) : void;

    /**
     * Метод ensureHasRegisteredDefinition проверяет что у сущности есть сохраненная реализация
     *
     * @method ensureHasRegisteredDefinition
     * @param Lotos\Collection\Collection $repository
     * @param string $class
     * @throws Lotos\DI\Repository\Exception\NotFoundRegisteredRealisationException
     * @return void
     */
    public function ensureHasRegisteredDefinition(Collection $repository, string $class) : void
}
