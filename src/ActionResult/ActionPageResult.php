<?php

namespace Siarko\ActionRouting\ActionResult;

use Siarko\BlockLayout\PageRenderer;
use Siarko\BlockLayout\XmlLayoutParser;

class ActionPageResult extends AbstractActionResult
{

    /**
     * @param PageRenderer $pageRenderer
     */
    public function __construct(
        private readonly PageRenderer $pageRenderer
    )
    {
    }

    /**
     * @return XmlLayoutParser
     */
    public function getLayoutParser(): XmlLayoutParser{
        return $this->pageRenderer->getLayoutParser();
    }

    /**
     * Resolves the action result for page rendering
     */
    public function resolve(): void
    {
        $this->pageRenderer->render();
    }
}