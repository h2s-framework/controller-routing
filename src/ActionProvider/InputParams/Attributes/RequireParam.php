<?php

namespace Siarko\ActionRouting\ActionProvider\InputParams\Attributes;

use Attribute;
use Siarko\ActionRouting\Routing\Method;
use Siarko\Serialization\Api\Attribute\Serializable;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class RequireParam
{

    /**
     * @param string $name
     * @param Method $method
     * @param string $errorMessage
     */
    public function __construct(
        #[Serializable] private readonly string $name = '',
        #[Serializable] private readonly Method $method = Method::POST,
        #[Serializable] private readonly string $errorMessage = '%s is required'
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Method
     */
    public function getMethod(): Method
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return T($this->errorMessage, ucfirst($this->getName()));
    }

}