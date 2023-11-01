<?php

namespace Pkg6\Cache\Tests;

use Pkg6\Cache\cache\driver\File;
use Pkg6\Cache\cache\driver\Redis;
use Pkg6\Cache\facade\Cache;

class CacheTest extends \PHPUnit\Framework\TestCase
{
    public function testFileCache()
    {
        $f = new File([
            'expire' => 0,
            'cache_subdir' => true,
            'prefix' => '',
            'path' => './.test_data/',
            'hash_type' => 'md5',
            'data_compress' => false,
            'tag_prefix' => 'tag:',
            'serialize' => [],
        ]);
        $f->set("t", 1);
        $this->assertEquals($f->get("t"), 1);
        $this->assertEquals($f->has("t"), true);
        $f->delete("t");
        $this->assertEquals($f->get("t"), null);
    }
    public function testRedisCache()
    {
        $f = new Redis();
        $f->set("t", 1);
        $this->assertEquals($f->get("t"), 1);
        $this->assertEquals($f->has("t"), true);
        $f->delete("t");
        $this->assertEquals($f->get("t"), null);
    }
    public function testFacade()
    {
        Cache::config([
            'default'	=>	'file',
            'stores'	=>	[
                'file'	=>	[
                    'type'   => 'File',
                    // 缓存保存目录
                    'path' => './.test_data/',
                    // 缓存前缀
                    'prefix' => '',
                    // 缓存有效期 0表示永久缓存
                    'expire' => 0,
                ],
                'redis'	=>	[
                    'type'   => 'redis',
                    'host'   => '127.0.0.1',
                    'port'   => 6379,
                    'prefix' => '',
                    'expire' => 0,
                ],
            ],
        ]);
        Cache::set("tf",1);
        $this->assertEquals(Cache::get("tf"), 1);
        $this->assertEquals(Cache::get("tf"), 1);
        $this->assertEquals(Cache::has("tf"), true);
        Cache::delete("tf");
        $this->assertEquals(Cache::get("tf"), null);

        Cache::store("redis")->set("tfr",1);
        $this->assertEquals(Cache::store("redis")->get("tfr"), 1);
        $this->assertEquals(Cache::store("redis")->has("tfr"), true);
        Cache::store("redis")->delete("tfr");
        $this->assertEquals(Cache::store("redis")->get("tfr"), null);
    }
}