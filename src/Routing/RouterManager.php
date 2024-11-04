<?php

namespace Siarko\ActionRouting\Routing;

use MJS\TopSort\CircularDependencyException;
use MJS\TopSort\ElementNotFoundException;
use Siarko\ActionRouting\Api\Routing\RouterInterface;
use Siarko\ActionRouting\BuiltinAction\Action404Interface;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResultFactory;
use Siarko\ActionRouting\Routing\Url\RequestDataProviderInterface;
use Siarko\Api\Factory\FactoryProviderInterface;
use Siarko\Utils\Sorting\BeforeAfterSort;

class RouterManager implements RouterInterface
{

    public const CONFIG_KEY_CLASS = 'class';

    /**
     * @param BeforeAfterSort $sorter
     * @param Action404Interface $action404
     * @param RequestDataProviderInterface $requestDataProvider
     * @param UrlMatchResultFactory $urlMatchResultFactory
     * @param FactoryProviderInterface $factoryProvider
     * @param array $routers
     */
    public function __construct(
        private readonly BeforeAfterSort              $sorter,
        private readonly Action404Interface           $action404,
        private readonly RequestDataProviderInterface $requestDataProvider,
        private readonly UrlMatchResultFactory        $urlMatchResultFactory,
        private readonly FactoryProviderInterface     $factoryProvider,
        private readonly array                        $routers = []
    )
    {
    }

    /**
     * @return UrlMatchResult|null
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     */
    public function match(): ?UrlMatchResult
    {
        foreach ($this->getSortedRouters($this->routers) as $router) {
            $router = $this->getRouterInstance($router);
            if (($matchResult = $router->match()) !== null) {
                return $matchResult;
            }
        }
        return $this->get404MatchResult();
    }

    /**
     * @return UrlMatchResult
     */
    private function get404MatchResult(): UrlMatchResult
    {
        $result = $this->urlMatchResultFactory->create();
        $result->setFullUrl($this->requestDataProvider->getRequestUrl());
        $result->setRouteData($this->action404->getRouteData());
        return $result;
    }

    /**
     * @param string $routerType
     * @return RouterInterface
     */
    private function getRouterInstance(string $routerType): RouterInterface
    {
        $factory = $this->factoryProvider->getFactory($routerType);
        return $factory->create();
    }

    /**
     * @param array $routers
     * @return array
     * @throws CircularDependencyException
     * @throws ElementNotFoundException
     */
    private function getSortedRouters(array $routers): array
    {
        return array_map(
            fn($r) => $r[self::CONFIG_KEY_CLASS] ?? $r,
            $this->sorter->sort($routers)
        );
    }

}