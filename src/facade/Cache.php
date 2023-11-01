<?php

namespace Pkg6\Cache\facade;

use Pkg6\Cache\CacheManager;

/**
 * @Cache CacheManager
 * @see CacheManager
 * @mixin CacheManager
 */
class Cache
{
    protected static $_instance;

    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
        if (!$instance) {
            throw new \RuntimeException('A facade root has not been set.');
        }
        return $instance->$method(...$args);
    }

    protected static function getFacadeRoot()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = self::getFacadeAccessor();
        }
        return self::$_instance;
    }

    protected static function getFacadeAccessor()
    {
        return new CacheManager;
    }
}