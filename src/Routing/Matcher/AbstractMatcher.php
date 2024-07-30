<?php

namespace Siarko\ActionRouting\Routing\Matcher;

abstract class AbstractMatcher implements MatcherInterface {

    /**
     * @param $string
     * @return string
     */
    private function packageRegex($string): string
    {
        return '#'.$string.'#';
    }

    /**
     * @param string $url
     * @param string $regex
     * @return UrlMatchResult|null
     */
    public function _match(string $url, string $regex) : ?UrlMatchResult{
        return $this->match($url, $this->packageRegex($regex));
    }

    /**
     * @param string $url
     * @param string $regex
     * @return UrlMatchResult|null
     */
    public abstract function match(string $url, string $regex) : ?UrlMatchResult;
}