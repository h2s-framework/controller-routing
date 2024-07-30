<?php

namespace Siarko\ActionRouting\ActionProvider\InputParams\ErrorHandler;

use Siarko\ActionRouting\ActionProvider\InputParams\Attributes\RequireParam;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\IAction;

interface InputErrorHandlerInterface
{

    /**
     * @param RequireParam $attribute
     * @param IAction $action
     * @return AbstractActionResult|null
     */
    public function handle(RequireParam $attribute, IAction $action): ?AbstractActionResult;
}