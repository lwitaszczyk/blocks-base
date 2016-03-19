<?php

namespace Blocks;

interface Cache
{
    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * @param $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param $key
     * @param $value
     * @param int $ttl
     *
     * @return self
     */
    public function set($key, $value, $ttl = 0);

    /**
     * @return self
     */
    public function clear();
}
