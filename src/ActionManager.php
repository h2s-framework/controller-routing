<?php

namespace Siarko\ActionRouting;

use Siarko\ActionRouting\ActionProvider\InputParams\InputParamValidator;
use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\Api\Routing\RouterInterface;
use Siarko\Api\Factory\ObjectCreatorInterface;

class ActionManager
{

    /**
     * @param RouterInterface $router
     * @param AbstractActionResult $actionNoResult
     * @param InputParamValidator $actionInputParamValidator
     * @param ObjectCreatorInterface $objectCreator
     */
    public function __construct(
        private readonly RouterInterface      $router,
        private readonly AbstractActionResult $actionNoResult,
        private readonly InputParamValidator $actionInputParamValidator,
        private readonly ObjectCreatorInterface $objectCreator
    )
    {
    }


    /**
     * Actual request resolver
     */
    public function resolve()
    {
        $routeData = $this->getRouteData();
        $actionResult = $this->executeAction($routeData);
        if ($actionResult === null) {
            $actionResult = $this->actionNoResult;
        }
        $actionResult->resolve();
    }

    /**
     * @return RouteData
     */
    protected function getRouteData(): RouteData
    {
        $matchResult = $this->router->match();
        return $matchResult->getRouteData();
    }

    /**
     * @param RouteData $routeData
     * @return AbstractActionResult|null
     */
    protected function executeAction(RouteData $routeData): ?AbstractActionResult
    {
        /** @var IAction $actionInstance */
        $actionInstance = $this->objectCreator->createObject($routeData->getClassName());
        $validationResult = $this->actionInputParamValidator->validate($routeData, $actionInstance);
        if($validationResult !== null){
            return $validationResult;
        }
        $methodName = $routeData->getMethodName();
        return $actionInstance->$methodName();
    }

}