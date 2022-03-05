<?php

declare(strict_types=1);

namespace Lotos\DI\Repository;

use \ReflectionClass;
use Lotos\Collection\Collection;
use Lotos\DI\Repository\RepositoryInterface;
use Lotos\DI\Repository\Factories\{DefinitionFactory, MethodFactory};
use Lotos\DI\Repository\Entities\{
    RepositoryValidator,
    Definition,
    ArgumentEntity,
    ArgumentsCollectionFactory
};
use Lotos\DI\Repository\Exception\{
    WrongArgumentTypeException,
    SaveAlreadySavedClass,
    RepositoryException,
    SaveAlreadySavedInterface,
    NotFoundRegisteredRealisationException
};

/**
 * Класс Repository хранит в себе созданные сущности и их зависимости
 *
 * Основные задачи репозитория - сохранять и предоставлять объекты и их зависимости
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository
 * @version 2.0.0
 */
class Repository implements RepositoryInterface
{
    use RepositoryValidator;

    /**
     * @method __constructor
     * @param Lotos\Collection\Collection $storage Коллекция для хранения сущностей
     */
    public function __construct(
        private Collection $storage
    )
    {
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::saveClass
     */
    public function saveClass(string $class) : void
    {
        try {
            $this->ensureInstantiable($class);
            $this->ensureUniqueClass($this->storage, $class);
            $entity = DefinitionFactory::createDefinition(
                (new ReflectionClass($this->storage))->newInstance()
            );
            $entity->setClass($class);
            $this->storage->push($entity);
        } catch(WrongArgumentTypeException | SaveAlreadySavedClass $e) {
            throw new RepositoryException($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::getByClass
     */
    public function getByClass(string $class) : Definition
    {
        try {
            $this->ensureHasRegisteredDefinition($this->storage, $class);
            return $this->storage->where('class', $class)->first();
        } catch(NotFoundRegisteredRealisationException $e) {
            throw new RepositoryException($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::saveInterface
     */
    public function saveInterface(string $interface) : void
    {
        try {
            $this->ensureValidInterface($interface);
            $this->ensureUniqueInterface($this->storage, $interface);
            $this->storage->last()->addInterface($interface);
        } catch (SaveAlreadySavedInterface $e) {
            throw new RepositoryException($e->getMessage() . PHP_EOL . $e->getTraceAsString());
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::addParam
     */
    public function addParam(string $method, ArgumentEntity $argument) : void
    {
        $method = MethodFactory::createMethod(
            $method,
            ArgumentsCollectionFactory::createCollection([$argument])
        );
        $this->storage->last()->addOrUpdate($method);
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::addParams
     */
    public function addParams(string $method, Collection $params) : void
    {
        $method = MethodFactory::createMethod($method, $params);
        $this->storage->last()->addOrUpdate($method);
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::setAlias
     */
    public function setAlias(string $alias) : void
    {
        $this->storage->last()->setAlias($alias);
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::getByAlias
     */
    public function getByAlias(string $alias) : ?Definition
    {
        return ($this->storage->where('alias', $alias)->count() > 0)
            ? $this->storage->where('alias', $alias)->first()
            : null;
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::getByInterface
     */
    public function getByInterface(string $interface) : Collection
    {
       return $this->storage->filter(function($entity) use ($interface) {
            if($entity->getInterfaces()->count() > 0) {
                return (
                    $entity
                        ->getInterfaces()
                        ->filter(
                            function($item) use ($interface) {
                                return ($item == $interface);
                            }
                        )->count() > 0
                );
            }
            return false;
        });
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::checkExists
     */
    public function checkExists(string $alias) : bool
    {
        return (
            $this->storage->where('alias', $alias)->count() === 1 ||
            $this->storage->where('class', $alias)->count() === 1 ||
            $this->storage->filter(function($item) use ($alias) {
                return $item->getInterfaces()->contains($alias);
            })->count() > 0
        );
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::saveInstance
     */
    public function saveInstance(object $object) : void
    {
        $this->storage->last()->setInstance($object);
    }

    /**
     * @see Lotos\DI\Repository\RepositoryInterface::setPriority
     */
    public function setPriority(int $priority) : void
    {
        $this->storage->last()->setPriority($priority);
    }
}
