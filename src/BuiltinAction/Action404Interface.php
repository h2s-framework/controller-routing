<?php

namespace Siarko\ActionRouting\BuiltinAction;

use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\IAction;

interface Action404Interface extends IAction
{

    /**
     * @return AbstractActionResult|null
     */
    public function run(): ?AbstractActionResult;

    /**
     * @return RouteData
     */
    public function getRouteData(): RouteData;

}