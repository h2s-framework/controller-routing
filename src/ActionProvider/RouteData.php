<?php

namespace Siarko\ActionRouting\ActionProvider;

use Siarko\ActionRouting\ActionProvider\InputParams\Attributes\RequireParam;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;
use Siarko\Serialization\Api\Attribute\Serializable;

class RouteData
{

    /**
     * @param ParametricUrl[] $routes
     * @param string $className
     * @param string $methodName
     * @param array $requiredParams
     * @param array $metadata
     */
    public function __construct(
        #[Serializable] protected array $routes,
        #[Serializable] protected string $className,
        #[Serializable] protected string $methodName,
        #[Serializable] protected array $requiredParams,
        #[Serializable] protected array $metadata = []
    )
    {
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return RequireParam[]
     */
    public function getRequiredParams(): array
    {
        return $this->requiredParams;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

}