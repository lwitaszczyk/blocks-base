<?php

namespace Blocks\DI\Exception;

use Blocks\DI\Service;

class CannotOverrideDefinedServiceException extends ContainerException
{
    public function __construct(Service $service)
    {
        parent::__construct(
            sprintf(
                'Service [%s] cannot override because is already defined',
                $service->getId()
            )
        );
    }
}
