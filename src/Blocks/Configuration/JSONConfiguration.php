<?php

namespace Blocks\Configuration;

class JSONConfiguration extends BaseConfiguration
{

    /**
     * JSONConfiguration constructor.
     * @param string $fileName
     * @throws \Exception
     */
    public function __construct($fileName)
    {
        if (file_exists($fileName)) {
            $config = json_decode(
                file_get_contents($fileName),
                true
            );
        } else {
            throw new \Exception(sprintf('Configuration file %s not exists', $fileName));
        }

        parent::__construct($config);
    }
}
