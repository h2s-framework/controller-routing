<?php

namespace Siarko\ActionRouting\ActionResult;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\UrlService\Processor\UrlProcessorManager;
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

    /**
     * @param UrlProvider $baseUrlProvider
     * @param UrlProcessorManager $urlProcessorManager
     */
    public function __construct(
        private readonly UrlProvider $baseUrlProvider,
        private readonly UrlProcessorManager $urlProcessorManager
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
        header("Location: ".$this->resolveUrl());
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

    /**
     * @return string
     * @throws RootPathNotSet
     */
    protected function resolveUrl(): string
    {
        if($this->isAbsolute()){
            return $this->getRedirectUrl();
        }
        return $this->urlProcessorManager->process(
            $this->getRedirectUrl(),
            $this->baseUrlProvider->getCurrentUrl()
        );
    }
}