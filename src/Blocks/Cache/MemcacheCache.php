<?php

namespace Blocks\Cache;

use Blocks\Cache;
use Memcache;

class MemcacheCache implements Cache
{
    /**
     * Memcache
     */
    private $memcache = null;

    /**
     * @var int
     */
    private $defaultTtl;

    /**
     * Memcache constructor.
     * @param string $host
     * @param int $port
     * @param int $defaultTtl
     */
    public function __construct($host = '127.0.0.1', $port = 11211, $defaultTtl = 3600)
    {
        $this->memcache = new Memcache();
        $this->memcache->connect($host, $port);
        $this->defaultTtl = (int)$defaultTtl;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return ($value = $this->memcache->get($key)) ? $value : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = null)
    {
        if (is_null($ttl)) {
            $ttl = $this->defaultTtl;
        }
        $this->memcache->set($key, $value, false, $ttl);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return ($this->memcache->get($key) !== false);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this;
    }
}
