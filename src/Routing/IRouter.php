<?php

namespace Siarko\ActionRouting\Routing;

use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;

interface IRouter
{

    /**
     * @param string $className
     * @param string $method
     * @return void
     */
    public function setNotFoundAction(string $className, string $method): void;

    /**
     * @param RouteData $routeData
     * @return void
     */
    public function registerRoutes(RouteData $routeData): void;

    /**
     * @return UrlMatchResult
     */
    public function match(): UrlMatchResult;
}