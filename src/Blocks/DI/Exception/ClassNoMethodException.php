<?php

namespace Blocks\DI\Exception;

use Blocks\DI\Service;
use Blocks\DI\DIByCall;

class ClassNoMethodException extends ContainerException
{

    public function __construct(DIByCall $call, \ReflectionClass $reflection, Service $service)
    {
        parent::__construct(
            sprintf(
                'Class [%s] no method [%s] on service [%s]',
                $reflection->getName(),
                $call->getMethodName(),
                $service->getId()
            )
        );
    }
}
