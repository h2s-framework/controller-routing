<?php

namespace Siarko\ActionRouting\ActionProvider\ControllerFiles;

class DefaultRouteBuilder implements RoutePathBuilderInterface
{

    /**
     * @param array $actionFiles
     * @return array
     */
    public function build(array $actionFiles): array
    {
        $result = [];
        foreach ($actionFiles as $route => $path) { //add correct regex prefix and suffix
            $result['^' . $route . '$'] = $path;
        }
        if (array_key_exists('index', $actionFiles)) { //find index action and assign correct path to it
            $result['^$'] = $actionFiles['index'];
        }
        return $result;
    }
}