<?php

namespace Blocks\Configuration;

use Blocks\Configuration;
use Symfony\Component\Yaml\Yaml;

class YmlConfiguration implements Configuration
{

    /**
     * @var mixed[]
     */
    private $config;

    /**
     * YmlConfiguration constructor.
     * @param $fileName
     * @throws \Exception
     */
    public function __construct($fileName)
    {
        $this->config = [];

        if (file_exists($fileName)) {
            $this->config = Yaml::parse(
                file_get_contents($fileName)
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
