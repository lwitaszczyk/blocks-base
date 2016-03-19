<?php

namespace Blocks\Cache;

use Blocks\Cache;

class FileCache implements Cache
{

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var int
     */
    private $defaultTtl;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $suffix;

    public function __construct($cacheDir = null, $defaultTtl = 3600, $prefix = '', $suffix = '.php.cache')
    {
        $this->cacheDir = (string)$cacheDir;
        $this->prefix = (string)$prefix;
        $this->suffix = (string)$suffix;
        $this->defaultTtl = (int)$defaultTtl;

        if ($defaultTtl < 1) {
            throw new \Exception('ttl cant be lower than 1');
        }

        if (!$this->cacheDir) {
            $$this->cacheDir = realpath(sys_get_temp_dir()) . '/cache';
        }

        if (!is_dir($this->cacheDir)) {
            if (!mkdir($this->cacheDir, 0777, true)) {
                throw new \Exception($this->cacheDir . ' is not writable');
            }
        }

        if (!is_writable($this->cacheDir)) {
            throw new \Exception($this->cacheDir . ' is not writable');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function del($key)
    {
        $key = $this->getKey($key);
        $cacheFile = $this->getFileName($key);
        if (is_file($cacheFile)) {
            unlink($cacheFile);
        }
        return $this;
    }

    private function getKey($key)
    {
        return sprintf('%s%s%s', $this->prefix, $key, $this->suffix);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $path = $this->getFileName($this->getKey($key));

        if (!file_exists($path)) {
            return $default;
        }

        $data = unserialize(file_get_contents($path));
        if (!$data || !$this->validateDataFromCache($data) || $this->ttlHasExpired($data['ttl'])) {
            return $default;
        }

        return $data['value'];
    }

    private function validateDataFromCache($data)
    {
        if (!is_array($data)) {
            return false;
        }
        foreach (['value', 'ttl'] as $missing) {
            if (!array_key_exists($missing, $data)) {
                return false;
            }
        }

        return true;
    }

    protected function ttlHasExpired($ttl)
    {
        return (time() > $ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return !is_null($this->get($key));
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $ttl = null)
    {
        $cacheFile = $this->getFileName($key);
        if (!$ttl) {
            $ttl = $this->defaultTtl;
        }
        $item = serialize(
            [
                'value' => $value,
                'ttl' => (int)$ttl + time(),
            ]
        );
        if (!file_put_contents($cacheFile, $item)) {
            throw new \Exception(sprintf('Error saving data with the key "%s" to the cache file.', $key));
        }
    }

    public function clear()
    {
        //@TODO delete all files
    }

    private function getFileName($key)
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . $this->getKey($key);
    }
}
