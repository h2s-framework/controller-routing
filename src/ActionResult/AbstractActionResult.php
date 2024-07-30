<?php

namespace Siarko\ActionRouting\ActionResult;

use Siarko\ActionRouting\IAction;

abstract class AbstractActionResult
{
    private ?IAction $action;

    public function setAction(IAction $action): static{
        $this->action = $action;
        return $this;
    }

    /**
     * @return IAction
     */
    public function getAction(): IAction
    {
        return $this->action;
    }

    /**
     *
     */
    public abstract function resolve(): void;
}