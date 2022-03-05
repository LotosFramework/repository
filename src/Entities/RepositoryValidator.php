<?php

declare(strict_types=1);

namespace Lotos\DI\Repository\Entities;

use \ReflectionClass;
use \ReflectionException;
use Lotos\Collection\Collection;
use Lotos\DI\Repository\Exception\{
    SaveAlreadySavedClass,
    SaveAlreadySavedInterface,
    WrongArgumentTypeException,
    NotFoundRegisteredRealisationException
};

/**
 * Trait RepositoryValidator валидирует параметры, сохраняемые в репозиторий
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository\Entities
 * @version 2.0.0
 */
trait RepositoryValidator
{

    /**
     * @see Lotos\DI\Repository\RepositoryValidatorInterface::ensureUniqueClass
     */
    public function ensureUniqueClass(Collection $repository, string $class) : void
    {
        if($repository->where('class', $class)->count() > 0) {
            throw new SaveAlreadySavedClass('Class ' . $class . ' already registered and can\'t be registered again.');
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryValidatorInterface::ensureUniqueInterface
     */
    public function ensureUniqueInterface(Collection $repository, string $interface) : void
    {
        $repository->map(function($entity) use ($interface) {
            if ($entity->getInterfaces()->count() > 0) {
                $entity->getInterfaces()->map(function($item) use ($interface) {
                    if ($item === $interface) {
                        throw new SaveAlreadySavedInterface('Interface ' . $interface . ' already registered and can\'t be registered again.');
                    }
                });
            }
        });
    }

    /**
     * @see Lotos\DI\Repository\RepositoryValidatorInterface::ensureInstantiable
     */
    public function ensureInstantiable(string $class) : void
    {
        try {
            $ref = new ReflectionClass($class);
            if (!$ref->isInstantiable()) {
                throw new WrongArgumentTypeException($class .' can\'t be instantiable. It\'s not a class.');
            }
        } catch(ReflectionException $e) {
            throw new WrongArgumentTypeException($e->getMessage());
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryValidatorInterface::ensureValidInterface
     */
    public function ensureValidInterface(string $interface) : void
    {
        try {
            $ref = new ReflectionClass($interface);
            if (!$ref->isInterface()) {
                throw new WrongArgumentTypeException($interface . ' is can\'t be implemented. It\'s not a interface.');
            }
        } catch(ReflectionException $e) {
            throw new WrongArgumentTypeException($e->getMessage());
        }
    }

    /**
     * @see Lotos\DI\Repository\RepositoryValidatorInterface::ensureHasRegisteredDefinition
     */
    public function ensureHasRegisteredDefinition(Collection $repository, string $class) : void
    {
        if ($this->storage->where('class', $class)->count() === 0) {
            throw new NotFoundRegisteredRealisationException('Not found registered realisation for ' . $class);
        }
    }
}
