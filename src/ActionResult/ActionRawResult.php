<?php

namespace Siarko\ActionRouting\ActionResult;

class ActionRawResult extends AbstractActionResult
{

    private string $html = '';
    private array $headers = [];

    /**
     * @param string $html
     * @return void
     */
    public function setHtml(string $html): void
    {
        $this->html = $html;
    }

    /**
     * @param string $header
     * @return void
     */
    public function addHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    /**
     * @inheritDoc
     */
    public function resolve(): void
    {
        foreach ($this->headers as $header) {
            header($header);
        }
        echo $this->html;
    }
}