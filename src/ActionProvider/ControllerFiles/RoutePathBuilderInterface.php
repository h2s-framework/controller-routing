<?php

namespace Siarko\ActionRouting\ActionProvider\ControllerFiles;

interface RoutePathBuilderInterface
{

    /**
     * Builds an array of routes from the given array of action files
     * @param array $actionFiles
     * @return array
     */
    public function build(array $actionFiles): array;
}