<?php

declare(strict_types=1);

namespace Lotos\DI\Repository;

use Lotos\Collection\Collection;
use Lotos\DI\Repository\Entities\{Definition, ArgumentEntity, ArgumentsCollection};
/**
 * Интерфейс RepositoryInterface
 *
 * @author McLotos <mclotos@xakep.ru>
 * @copyright https://github.com/LotosFramework/Repository/COPYRIGHT.md
 * @license https://github.com/LotosFramework/Repository/LICENSE.md
 * @package Lotos\DI
 * @subpackage Repository
 * @version 2.0.0
 */
interface RepositoryInterface
{

    /**
     * Метод saveClass Сохраняет класс в репозиторий
     *
     * Сохраненный классы используются для создания объектов,
     *  настройки зависимостей и быстрого поиска
     *
     * @method saveClass
     * @param string $class Имя класса, который нужно сохранить в репозиторий
     * @throws Lotos\DI\Repository\Exception\RepositoryException Исключение выдается если
     *  пытаются сохранить не класс
     *  или класс уже сохранен
     * @return void
     */
    public function saveClass(string $class) : void;

    /**
     * Метод getByClass Возвращает сохраненную сущность для дальнейшей работы с ней
     *
     * @method getByClass
     * @param string $class Имя класса, который нужно найти в репозитории
     * @throws Lotos\DI\Repository\Exception\RepositoryException Исключение выдается если ничего не найдено
     * @return Lotos\DI\Repository\Entities\Definition
     */
    public function getByClass(string $class) : ?Definition;

    /**
     * Метод saveInterface Сохраняет интерфейс, по которому можно будет искать класс
     *
     * Для соблюдения рекомендаций SOLID, в репозитории имеется привязка
     *  сущностей к интерфейсам, чтобы DI мог заменять интерфейсы на объекты
     *
     * @method saveInterface
     * @param string $interface Имя интерфейса, который нужно привязать к сохраненному классу
     * @throws Lotos\DI\Repository\Exception\RepositoryException Исключение выдается если интерфейс уже был сохранен ранее
     * @return void
     */
    public function saveInterface(string $interface) : void;

    /**
     * Метод addParam Создает параметр для функций
     *
     * Иногда для некоторых методов могут понадобиться объекты или сущности,
     *   которые нельзя создать "на лету", чтобы не нарушать SOLID
     *   для таких случаев можно заранее сохранить в репозиторий
     *   все аргументы всех функций, которые могут понадобиться сохраняемому объекту
     *
     * @method addParam
     * @param string $method Название метода, для которого сохраняется аргумент
     * @param Lotos\DI\Repository\Entities\ArgumentEntity Сущность сохраняемого аргумента
     * @return void
     */
    public function addParam(string $method, ArgumentEntity $paramValue) : void;

    /**
     * @see addParam
     *
     * Такой же по сути метод как addParam,
     * только позволяет сохранять сразу коллекцию аргументов
     *
     * @method addParams
     * @param string $method Название метода, для которого сохраняется аргумент
     * @param Lotos\DI\Repository\Entities\ArgumentsCollection Коллекция аргументов
     * @return void
     */
    public function addParams(string $method, ArgumentsCollection $params) : void;

    /**
     * Метод setAlias устанавливает текстовый алиас для удобного вызова сущнстей
     *
     * Алиас привязывается к сохраняемой сущности и может использоваться для быстрого её поиска
     *
     * @method setAlias
     * @param string $alias Текстовый alias для сохраняемого объекта
     * @return void
     */
    public function setAlias(string $alias) : void;

    /**
     * Метод getByAlias находит сущность в репозитории по ее алиасу
     *
     * @method getByAlias
     * @param string $alias Алиас, по которому нужно искать сущность
     * @return Lotos\DI\Repository\Entities\Definition | null Возвращает сущность, если она зарегистрирована
     */
    public function getByAlias(string $alias) : ?Definition;

    /**
     * Метод getByInterface позволяет находить сущности, по интерфейсу
     *
     * @method getByInterface
     * @param string $interface Название интерфейса, по которому нужно искать сущности
     * @return Lotos\Collection\Collection Всегда возвращает коллекцию
     */
    public function getByInterface(string $interface) : Collection;


    /**
     * Метод checkExists проверяет существование сущности по алиасу
     *
     * @method checkExists
     * @param string $alias Алиас, по которому нужно искать сущность
     * @return bool Возвращает true если сущность найдена, или false
     */
    public function checkExists(string $alias) : bool;


    /**
     * Метод saveInstance сохраняет созданные объекты после их сборки
     *
     * Метод хранит созданные объекты, чтобы их можно было не пересоздавать
     *
     * @method saveInstance
     * @param object $object Объект, состояние которого нужно сохранить
     * @return void
     */
    public function saveInstance(object $object) : void;

    /**
     * Метод setPriority устанавливает приоритет на сохраняему сущность
     *
     * Приоритеты могут пригодиться, если под одним интерфейсом сохранены разные классы
     *   но при правильной архитектуре приложения, приоритеты - лишний функционал
     *
     * @method setPriority
     * @param int $priority Приоритет сохраняемой сущности, по умолчанию 0
     * @return void
     */
    public function setPriority(int $priority) : void;
}
