<?php

namespace Blocks\Configuration;

use Symfony\Component\Yaml\Yaml;

class YmlConfiguration extends BaseConfiguration
{

    /**
     * YmlConfiguration constructor.
     * @param $fileName
     * @throws \Exception
     */
    public function __construct($fileName)
    {
        if (file_exists($fileName)) {
            $config = Yaml::parse(
                file_get_contents($fileName)
            );
        } else {
            throw new \Exception(sprintf('Configuration file %s not exists', $fileName));
        }

        parent::__construct($config);
    }
}
