<?php

namespace Siarko\ActionRouting\BuiltinAction;

use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\ActionProvider\RouteDataFactory;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\ActionResult\ActionRawResult;

class Action404 implements Action404Interface
{

    /**
     * @param ActionRawResult $actionHtmlResult
     * @param RouteDataFactory $routeDataFactory
     */
    public function __construct(
        private readonly ActionRawResult $actionHtmlResult,
        private readonly RouteDataFactory $routeDataFactory
    )
    {
    }

    /**
     * @return AbstractActionResult|null
     */
    public function run(): ?AbstractActionResult
    {
        $this->actionHtmlResult->setHtml("404 Page not found :/");
        $this->actionHtmlResult->addHeader('HTTP/1.0 404 Not Found');
        return $this->actionHtmlResult;
    }

    /**
     * @return RouteData
     */
    public function getRouteData(): RouteData
    {
        return $this->routeDataFactory->createNamed(
            routes: [],
            className: self::class,
            methodName: 'run'
        );
    }
}