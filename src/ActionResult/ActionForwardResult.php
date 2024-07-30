<?php

namespace Siarko\ActionRouting\ActionResult;

class ActionForwardResult extends AbstractActionResult
{

    public function __construct(protected string $path)
    {
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @inheritDoc
     */
    public function resolve(): void
    {
        // TODO: Implement resolve() method.
    }
}