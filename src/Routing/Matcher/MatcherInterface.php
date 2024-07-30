<?php
namespace Siarko\ActionRouting\Routing\Matcher;

interface MatcherInterface {

    public function match(string $url, string $regex) : ?UrlMatchResult;
}