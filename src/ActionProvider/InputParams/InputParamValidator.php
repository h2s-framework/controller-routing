<?php

namespace Siarko\ActionRouting\ActionProvider\InputParams;

use Siarko\ActionRouting\ActionProvider\InputParams\ErrorHandler\InputErrorHandlerInterface;
use Siarko\ActionRouting\ActionProvider\RouteData;
use Siarko\ActionRouting\ActionResult\AbstractActionResult;
use Siarko\ActionRouting\IAction;
use Siarko\ActionRouting\Routing\Method;
use Siarko\ActionRouting\Routing\Url\RequestDataProvider;

class InputParamValidator
{

    /**
     * @param InputErrorHandlerInterface $errorHandleAction
     * @param RequestDataProvider $requestDataProvider
     */
    public function __construct(
        private readonly InputErrorHandlerInterface $errorHandleAction,
        private readonly RequestDataProvider $requestDataProvider
    )
    {
    }

    /**
     * @param RouteData $paramData
     * @param IAction $action
     * @return AbstractActionResult|null
     */
    public function validate(RouteData $paramData, IAction $action): ?AbstractActionResult
    {
        foreach ($paramData->getRequiredParams() as $requiredParam) {
            if($requiredParam->getMethod() === Method::GET){
                $value = $this->requestDataProvider->get($requiredParam->getName());
            }else{
                $value = $this->requestDataProvider->post($requiredParam->getName());
            }
            if(empty($value)){
                return $this->errorHandleAction->handle($requiredParam, $action);
            }
        }
        return null;
    }
}