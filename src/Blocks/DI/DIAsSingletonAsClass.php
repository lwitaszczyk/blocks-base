<?php

namespace Blocks\DI;

class DIAsSingletonAsClass extends DIAsSingleton
{
    /**
     * @param $className
     */
    public function __construct($className)
    {
        parent::__construct($className, $className);
    }
}
