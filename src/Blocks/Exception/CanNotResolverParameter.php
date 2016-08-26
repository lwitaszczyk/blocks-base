<?php

namespace Blocks\Exception;

use Exception;

class CanNotResolverParameter extends \Exception
{
    /**
     * @inheritDoc
     */
    public function __construct($method, $className, $paramName)
    {
        parent::__construct(
            sprintf(
                'Can not invoke method [%s] in class [%s] because can not resolve parameter [%s]',
                $method,
                $className,
                $paramName
            )
        );
    }
}
