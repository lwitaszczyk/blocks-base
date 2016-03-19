<?php

namespace Blocks;

interface Configuration
{
    /**
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set($key, $value);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key);
}
