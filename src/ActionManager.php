<?php

namespace Siarko\ActionRouting;

use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use Siarko\ActionRouting\ActionProvider\InputParams\InputParamValidator;
use Siarko\ActionRouting\ActionProvider\Provider;
use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\Routing\IRouter;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;
use Siarko\DependencyManager\DependencyManager;

class ActionManager
{

    /**
     * @param IRouter $router
     * @param DependencyManager $dependencyManager
     * @param AbstractActionResult $actionNoResult
     * @param InputParamValidator $actionInputParamValidator
     * @param Provider $actionProvider
     */
    public function __construct(
        private readonly IRouter $router,
        private readonly DependencyManager $dependencyManager,
        private readonly AbstractActionResult $actionNoResult,
        private readonly InputParamValidator $actionInputParamValidator,
        protected readonly Provider $actionProvider
    )
    {
        $this->registerRoutes();
    }


    /**
     * Register routes in router
     */
    protected function registerRoutes()
    {
        foreach ($this->actionProvider->getRoutes() as $routeData) {
            $this->router->registerRoutes($routeData);
        }
    }

    /**
     * Actual request resolver
     */
    public function resolve()
    {
        /** @var UrlMatchResult $matchResult */
        $matchResult = $this->router->match();
        $actionResult = $this->executeAction($matchResult->getRouteData());
        if ($actionResult === null) {
            $actionResult = $this->actionNoResult;
        }
        $actionResult->resolve();
    }

    /**
     * @param RouteData $data
     * @return AbstractActionResult|null
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     * @throws \ReflectionException
     */
    protected function executeAction(RouteData $data): ?AbstractActionResult
    {
        /** @var IAction $actionInstance */
        $actionInstance = $this->dependencyManager->get($data->getClassName());
        $validationResult = $this->actionInputParamValidator->validate($data, $actionInstance);
        if($validationResult !== null){
            return $validationResult;
        }
        $methodName = $data->getMethodName();
        return $actionInstance->$methodName();
    }

}