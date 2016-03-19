<?php

namespace Blocks\DI\Exception;

use Blocks\DI\Service;

class CallInjectionAlreadyDefinedException extends ContainerException
{

    public function __construct($methodName, Service $service)
    {
        parent::__construct(
            sprintf(
                'Call injection [%s] for service [%s] already defined',
                $methodName,
                $service->getId()
            )
        );
    }
}
