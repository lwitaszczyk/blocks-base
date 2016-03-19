<?php

namespace Blocks;

class NullConfiguration implements Configuration
{

    /**
     * @var mixed[]
     */
    private $config;

    /**
     * DynamicConfiguration constructor.
     */
    public function __construct()
    {
        $this->config = [];
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $value = $this->config;

        $keys = explode('.', $key);
        $key = reset($keys);

        do {
            if (array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return $default;
            }
            $key = next($keys);
        } while ($key !== false);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $keys = explode('.', $key);

        $ref = $this->config;
        foreach ($keys as $key) {
            if (!array_key_exists($key, $ref)) {
                $ref[$key] = [];
            }
            $ref = $ref[$key];
        }
        $ref[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        $value = $this->config;

        $keys = explode('.', $key);
        $key = reset($keys);

        do {
            if (array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                return false;
            }
            $key = next($keys);
        } while ($key !== false);

        return true;
    }
}
