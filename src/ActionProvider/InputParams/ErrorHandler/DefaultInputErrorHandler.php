<?php

namespace Siarko\ActionRouting\ActionProvider\InputParams\ErrorHandler;

use Siarko\ActionRouting\ActionProvider\InputParams\Attributes\RequireParam;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\ActionResult\ActionRedirectResult;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Url\RequestDataProvider;
use Siarko\Utils\Persistance\Messaging\MessageManager;

class DefaultInputErrorHandler implements InputErrorHandlerInterface
{

    /**
     * @param MessageManager $messageManager
     * @param RequestDataProvider $requestDataProvider
     * @param ActionRedirectResult $redirectResult
     */
    public function __construct(
        private readonly MessageManager $messageManager,
        private readonly RequestDataProvider $requestDataProvider,
        private readonly ActionRedirectResult $redirectResult
    )
    {
    }

    /**
     * @param RequireParam $attribute
     * @param IAction $action
     * @return AbstractActionResult|null
     */
    public function handle(RequireParam $attribute, IAction $action): ?AbstractActionResult
    {
        $this->messageManager->error($attribute->getErrorMessage());
        return $this->redirectResult->setUrl($this->requestDataProvider->getRefererUrl());
    }
}