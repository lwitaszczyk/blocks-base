<?php

namespace Blocks;

class NullCache implements Cache
{

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        return $default;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = 0)
    {
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
        return $this;
    }
}
