<?php

namespace Siarko\ActionRouting\Routing\Matcher;

class ParametricMatcher extends AbstractMatcher implements MatcherInterface {


    /**
     * @param UrlMatchResultFactory $urlMatchResultFactory
     */
    public function __construct(
        private readonly UrlMatchResultFactory $urlMatchResultFactory
    )
    {
    }

    /**
     * @param $route
     * @return array|string|null
     */
    private function transformRouteParams($route): array|string|null
    {
        return preg_replace('/(\$([a-zA-Z-\_0-9]+))/', '(?<$2>[^/.]*)', $route);
    }

    /**
     * @param string $url
     * @param string $regex
     * @return UrlMatchResult|null
     */
    public function match(string $url, string $regex): ?UrlMatchResult {
        $regex = $this->transformRouteParams($regex);
        $result = [];
        preg_match($regex, $url, $result);
        if(count($result) == 0){
            return null;
        }
        $urlMatchResult = $this->urlMatchResultFactory->create();
        $urlMatchResult->setFullUrl(array_shift($result));
        $urlMatchResult->setParams($result);
        return $urlMatchResult;
    }
}