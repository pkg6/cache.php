<?php

namespace Pkg6\Cache\facade;

use Pkg6\Cache\cache\Driver;
use Pkg6\Cache\CacheManager;
use Psr\Cache\CacheItemInterface;

/**
 * @method static void config(array $config)
 * @method static Driver store(string $name = '', bool $force = false)
 * @method static CacheItemInterface getItem($key)
 * @method static array|\Traversable getItems(array $keys = array())
 * @method static bool hasItem($key)
 * @method static bool clear()
 * @method static bool deleteItem($key)
 * @method static bool deleteItems(array $keys)
 * @method static bool save(CacheItemInterface $item)
 * @method static bool saveDeferred(CacheItemInterface $item)
 * @method static bool commit()
 * @method static mixed get($key, $default = null);
 * @method static bool set($key, $value, $ttl = null);
 * @method static bool delete($key);
 * @method static iterable getMultiple($keys, $default = null);
 * @method static bool setMultiple($values, $ttl = null);
 * @method static bool deleteMultiple($keys);
 * @method static bool has($key);
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