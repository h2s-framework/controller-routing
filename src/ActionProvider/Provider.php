<?php

namespace Siarko\ActionRouting\ActionProvider;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Siarko\ActionRouting\ActionProvider\Attributes\ActionMeta;
use Siarko\ActionRouting\ActionProvider\ControllerFiles\RoutePathBuilderInterface;
use Siarko\ActionRouting\ActionProvider\InputParams\Attributes\RequireParam;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Attributes\ParametricUrl;
use Siarko\Api\State\AppStateInterface;
use Siarko\CacheFiles\Api\CacheSetInterface;
use Siarko\DependencyManager\ClassNameResolver;
use Siarko\DependencyManager\Exceptions\CouldNotResolveNamespace;
use Siarko\Paths\Provider\AbstractPathProvider;
use Siarko\Files\Path\PathInfo;
use Siarko\Paths\Api\Provider\Pool\PathProviderPoolInterface;
use Siarko\Utils\Strings;

class Provider
{

    public const PATH_PROVIDER_POOL_TYPE = 'action';

    const ACTION_FILE_NAME = '/^.+\.php/i';

    /**
     * @param ClassNameResolver $classNameResolver
     * @param RoutePathBuilderInterface $routePathBuilder
     * @param PathInfo $pathInfo
     * @param CacheSetInterface $configCache
     * @param Strings $stringUtils
     * @param PathProviderPoolInterface $pathProviderPool
     * @param AppStateInterface $appState
     */
    public function __construct(
        protected readonly ClassNameResolver $classNameResolver,
        protected readonly RoutePathBuilderInterface $routePathBuilder,
        protected readonly PathInfo $pathInfo,
        protected readonly CacheSetInterface $configCache,
        protected readonly Strings $stringUtils,
        protected readonly PathProviderPoolInterface $pathProviderPool,
        protected readonly AppStateInterface $appState
    )
    {
    }

    /**
     * @return RouteData[]
     * @throws CouldNotResolveNamespace
     * @throws ReflectionException
     */
    public function getRoutes(): array
    {
        $scope = $this->appState->getAppScope();
        if(!$this->configCache->exists($scope)){
            $this->configCache->set($scope, $this->constructRoutes());
        }
        return $this->configCache->get($scope);
    }

    /**
     * @return RouteData[]
     * @throws ReflectionException
     * @throws CouldNotResolveNamespace
     */
    protected function constructRoutes(): array
    {
        $result = [];
        foreach ($this->pathProviderPool->getProviders(self::PATH_PROVIDER_POOL_TYPE) as $actionsPathProvider) {
            $result = array_merge($result, $this->constructProviderRoutes($actionsPathProvider));
        }
        return $result;
    }

    /**
     * @param AbstractPathProvider $pathProvider
     * @return RouteData[]
     * @throws ReflectionException
     * @throws CouldNotResolveNamespace
     */
    protected function constructProviderRoutes(AbstractPathProvider $pathProvider): array
    {
        $routeList = [];
        $actionFiles = $this->getActionFiles($pathProvider);
        $routeData = $this->routePathBuilder->build($actionFiles);
        foreach ($routeData as $route => $path) {
            $className = $this->classNameResolver->resolveFromFilePath($path);
            $reflection = new ReflectionClass($className);
            if (!$reflection->implementsInterface(IAction::class)) { continue; }
            foreach ($reflection->getMethods() as $method) {
                $routes = $this->readParametricUrl($method, $route);
                $paramData = $this->readParamData($method);
                if(count($routes) == 0){ continue; }
                $metadata = $this->readActionMetadata($method);
                $routeList[] = new RouteData($routes, $className, $method->getName(), $paramData, $metadata);
            }
        }
        return $routeList;
    }

    /**
     * Read ActionMeta attribute from action method and get metadata
     *
     * @param ReflectionMethod $method
     * @return array
     */
    protected function readActionMetadata(ReflectionMethod $method): array
    {
        foreach ($method->getAttributes(ActionMeta::class) as $item) {
            /** @var ActionMeta $attribute */
            $attribute = $item->newInstance();
            return $attribute->getMetadata();
        }
        return [];
    }

    /**
     * Read attribute from action method and get URL pattern
     * @param ReflectionMethod $method
     * @param string $default
     * @return array
     */
    protected function readParametricUrl(ReflectionMethod $method, string $default): array
    {
        $result = [];
        foreach ($method->getAttributes(ParametricUrl::class) as $item) {
            /** @var ParametricUrl $attribute */
            $attribute = $item->newInstance();
            if($attribute->getPattern() == null) {
                $attribute = new ParametricUrl($default);
            }
            $result[] = $attribute;
        }
        return $result;
    }

    /**
     * Scan FS for Action files
     * @param AbstractPathProvider $pathProvider
     * @return array
     */
    protected function getActionFiles(AbstractPathProvider $pathProvider): array
    {
        $pathInfo = $this->pathInfo->read($pathProvider->getConstructedPath());
        $files = $pathInfo->readDirectoryFiles(self::ACTION_FILE_NAME);
        $result = [];
        foreach ($files as $filePath) {
            $key = str_replace('\\', '/', strtolower(substr($filePath, strlen($pathProvider->getConstructedPath()), -4)));
            $result[$key] = $filePath;
        }
        return $result;
    }

    /**
     * @param ReflectionMethod $method
     * @return RequireParam[]
     */
    private function readParamData(ReflectionMethod $method): array
    {
        $result = [];
        foreach ($method->getAttributes(RequireParam::class) as $item) {
            /** @var RequireParam $attribute */
            $attribute = $item->newInstance();
            $result[] = $attribute;
        }
        return $result;
    }


}