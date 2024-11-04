<?php

namespace Siarko\ActionRouting\Api\Routing;

use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;

interface RouterInterface
{

    /**
     * @return ?UrlMatchResult
     */
    public function match(): ?UrlMatchResult;
}