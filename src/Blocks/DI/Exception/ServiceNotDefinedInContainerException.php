<?php

namespace Blocks\DI\Exception;

class ServiceNotDefinedInContainerException extends ContainerException
{
    /**
     * ServiceNotDefinedInContainerException constructor.
     * @param string $serviceName
     */
    public function __construct($serviceName)
    {
        parent::__construct(
            sprintf(
                'Service [%s] not defined in container',
                $serviceName
            )
        );
    }
}
