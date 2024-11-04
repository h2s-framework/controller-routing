<?php

namespace Siarko\ActionRouting\Routing\Url;

use Siarko\ActionRouting\Routing\Method;

interface RequestDataProviderInterface
{

    public function getRequestMethod(): Method;

    public function getRequestUrl(): string;

    public function setRequestMethod(Method $method): static;

    public function setRequestUrl(string $requestUrl): static;

    public function getBaseUrl(): string;

    public function post(string $name, $default = null): mixed;

    public function get(string $name, $default = null): mixed;
}