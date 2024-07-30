<?php

namespace Siarko\ActionRouting\ActionResult;

use Siarko\UrlService\UrlProvider;

class ActionRedirectResult extends AbstractActionResult
{

    /**
     * @var string
     */
    private string $redirectUrl = '';
    /**
     * @var bool
     */
    private bool $isAbsolute = false;

    public function __construct(
        private readonly UrlProvider $baseUrlProvider
    )
    {
    }

    /**
     * Set Redirect Url (relative)
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): static
    {
        $this->redirectUrl = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * Do actual redirect
     */
    public function resolve(): void
    {
        if($this->isAbsolute()){
            header("Location: ".$this->getRedirectUrl());
        }else{
            header('Location: ' . $this->baseUrlProvider->getBaseUrl() . '/' . ltrim($this->getRedirectUrl(), '/'));
        }
    }

    /**
     * @return bool
     */
    public function isAbsolute(): bool
    {
        return $this->isAbsolute;
    }

    /**
     * @param bool $isAbsolute
     */
    public function setAbsolute(bool $isAbsolute): void
    {
        $this->isAbsolute = $isAbsolute;
    }
}