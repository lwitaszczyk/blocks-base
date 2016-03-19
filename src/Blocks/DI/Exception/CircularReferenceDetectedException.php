<?php

namespace Blocks\DI\Exception;

use Blocks\DI\Service;

class CircularReferenceDetectedException extends ContainerException
{
    public function __construct(Service $service)
    {
        parent::__construct(
            sprintf(
                'Circular reference detected for service [%s]',
                $service->getId()
            )
        );
    }
}
