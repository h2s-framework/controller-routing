<?php

namespace Siarko\ActionRouting\ActionResult;

class ActionNoResult extends AbstractActionResult
{

    public function resolve(): void
    {
        echo ("Action ".get_class($this->getAction())." has no result!");
    }
}