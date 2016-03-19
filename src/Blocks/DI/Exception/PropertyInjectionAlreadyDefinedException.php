<?php

namespace Blocks\DI\Exception;

use Blocks\DI\Service;
use Blocks\DI\DIByProperty;

class PropertyInjectionAlreadyDefinedException extends ContainerException
{
    /**
     * PropertyInjectionAlreadyDefinedException constructor.
     * @param DIByProperty $property
     * @param Service $service
     */
    public function __construct(DIByProperty $property, Service $service)
    {
        parent::__construct(
            sprintf(
                'Property injection [%s] for service [%s] already defined',
                $property->getPropertyName(),
                $service->getId()
            )
        );
    }
}
