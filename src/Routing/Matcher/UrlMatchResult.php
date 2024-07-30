<?php

namespace Siarko\ActionRouting\Routing\Matcher;

use JetBrains\PhpStorm\Pure;
use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Method;

class UrlMatchResult
{

    private string $fullUrl = '';
    private array $parameters = [];
    private Method $method;

    private RouteData $routeData;


    /**
     * @param string $fullUrl
     * @return $this
     */
    public function setFullUrl(string $fullUrl): static
    {
        $this->fullUrl = $fullUrl;
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): static
    {
        $this->parameters = $params;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addParam(string $key, string $value): static
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return UrlMatchResult
     */
    private function setParam(string $key, string $value): static
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * @return RouteData
     */
    public function getRouteData(): RouteData
    {
        return $this->routeData;
    }

    /**
     * @param RouteData $routeData
     * @return $this
     */
    public function setRouteData(RouteData $routeData): static
    {
        $this->routeData = $routeData;
        return $this;
    }

    /**
     * @return Method
     */
    public function getMethod(): Method
    {
        return $this->method;
    }

    /**
     * @param Method $method
     * @return UrlMatchResult
     */
    public function setMethod(Method $method): static
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get Full Action Url
     * @return string
     */
    public function getActionUrl(): string
    {
        return $this->fullUrl;
    }

    /**
     * If parameter was set
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool{
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Get Parameter value
     * @param string|null $name
     * @param string|null $default
     * @return string|null
     */
    public function get(?string $name, ?string $default = null): ?string{
        return (array_key_exists($name, $this->parameters) ? $this->parameters[$name] : $default);
    }

}