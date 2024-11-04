<?php

namespace Siarko\ActionRouting\Routing\Url;

use Siarko\ActionRouting\Routing\Method;
use Siarko\UrlService\UrlProvider;
use Siarko\Utils\ArrayManager;

class RequestDataProvider implements RequestDataProviderInterface
{

    public const GET_URL_PARAM = '_URL';

    protected ?Method $requestMethod = null;

    protected ?string $requestUrl = null;


    public function __construct(
        protected readonly ArrayManager $arrayManager,
        protected readonly UrlProvider $baseUrlProvider
    )
    {
    }


    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrlProvider->getBaseUrl();
    }
    /**
     * @return Method
     * @throws \Siarko\ActionRouting\Routing\Exceptions\UnknownHttpMethodException
     */
    public function getRequestMethod(): Method
    {
        if($this->requestMethod == null){
            $this->setRequestMethod(Method::fromString($_SERVER['REQUEST_METHOD']));
        }
        return $this->requestMethod;
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getRefererUrl(bool $absolute = false): string
    {
        $referer = rtrim($_SERVER['HTTP_REFERER'] ?? $this->getBaseUrl(), '/');
        if($absolute){
            return $referer;
        }else{
            return substr($referer, strlen($this->getBaseUrl()));
        }
    }

    /**
     * @return string
     */
    public function getRequestUrl(): string
    {
        if($this->requestUrl == null){
            $this->setRequestUrl(
                $this->arrayManager->get(self::GET_URL_PARAM, $_GET, '')
            );
        }
        return rtrim($this->requestUrl, '/');
    }

    /**
     * @param Method $method
     * @return RequestDataProvider
     */
    public function setRequestMethod(Method $method): static
    {
        $this->requestMethod = $method;
        return $this;
    }

    /**
     * @param string $requestUrl
     * @return RequestDataProvider
     */
    public function setRequestUrl(string $requestUrl): static
    {
        $this->requestUrl = $requestUrl;
        return $this;
    }

    public function post(string $name = '', $default = null): mixed
    {
        return $this->arrayManager->get($name, $_POST, $default);
    }

    public function get(string $name = '', $default = null): mixed
    {
        return $this->arrayManager->get($name, $_GET, $default);
    }
}