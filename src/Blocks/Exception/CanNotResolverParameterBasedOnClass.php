<?php

namespace Blocks\Exception;

use Exception;

class CanNotResolverParameterBasedOnClass extends \Exception
{
    /**
     * @inheritDoc
     */
    public function __construct($method, $className, $paramName, $serviceId)
    {
        parent::__construct(
            sprintf(
                'Can not invoke method [%s] in class [%s] because can not resolve parameter [%s] - service [%s] not found',
                $method,
                $className,
                $paramName,
                $serviceId
            )
        );
    }
}
