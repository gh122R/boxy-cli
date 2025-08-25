<?php

declare(strict_types=1);

namespace App\Facades;

use App\Container\Container;
use Exception;

class Facade
{
    protected static ?Container $container = null;

    public static function setContainer(Container $container): void
    {
        self::$container = $container;
    }

    public static function getContainer(): Container|null
    {
        return self::$container ?? null;
    }

    public static function isContainerMounted(): bool
    {
        return self::getContainer() !== null;
    }

    /**
     * @throws Exception
     */
    protected static function getFacadeFoundation()
    {
        $object = self::$container->get(static::getAccessor()) ?? null;

        if ($object === null) {
           logger()->emergency('Не найден ацессор фасада');
        }

        return $object;
    }

    /**
     * @throws Exception
     */
    protected static function getAccessor(): string
    {
        throw new Exception('Фасад не реализует метод getAccessor');
    }

    public static function __callStatic($method, $parameters)
    {
        try {
            return self::getFacadeFoundation()->$method(...$parameters);
        }catch (Exception $exception){
            logger()->emergency($exception->getMessage());

            return null;
        }
    }
}