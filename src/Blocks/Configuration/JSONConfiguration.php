<?php

namespace Blocks\Configuration;

use Blocks\Configuration;

class JSONConfiguration implements Configuration
{

    /**
     * @var mixed[]
     */
    private $config;

    /**
     * JSONConfiguration constructor.
     * @param string $fileName
     * @throws \Exception
     */
    public function __construct($fileName)
    {
        $this->config = [];

        if (file_exists($fileName)) {
            $this->config = json_decode(
                file_get_contents($fileName),
                true
            );
        } else {
            throw new \Exception(sprintf('Configuration file %s not exists', $fileName));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $value = $this->config;

        $keys = explode('.', $key);
        $currentKey = reset($keys);

        do {
            if (array_key_exists($currentKey, $value)) {
                $value = $value[$currentKey];
            } else {
                return $default;
            }
            $currentKey = next($keys);
        } while ($currentKey !== false);

//        var_dump($key, $value);
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        // TODO: Implement set() method.
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
