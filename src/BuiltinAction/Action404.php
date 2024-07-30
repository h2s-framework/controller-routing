<?php

namespace Siarko\ActionRouting\BuiltinAction;

use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\ActionResult\ActionRawResult;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Matcher\UrlMatchResult;

class Action404 implements Action404Interface
{

    /**
     * @param ActionRawResult $actionHtmlResult
     */
    public function __construct(
        private readonly ActionRawResult $actionHtmlResult
    )
    {
    }

    /**
     * @return AbstractActionResult|null
     */
    public function run(): ?AbstractActionResult
    {
        $this->actionHtmlResult->setHtml("404 Page not found :/");
        $this->actionHtmlResult->addHeader('HTTP/1.0 404 Not Found');
        return $this->actionHtmlResult;
    }
}