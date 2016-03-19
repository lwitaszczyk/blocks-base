<?php

namespace Blocks\Cache;

use Blocks\Cache;

class ApcuCache implements Cache
{

    /**
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return ($value = apc_fetch($key)) ? $value : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = 0)
    {
        apc_store($key, $value, $ttl);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        apc_clear_cache();
        return $this;
    }
}
