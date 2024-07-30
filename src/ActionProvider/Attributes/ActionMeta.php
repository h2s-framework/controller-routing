<?php

namespace Siarko\ActionRouting\ActionProvider\Attributes;

use Attribute;
use Siarko\Serialization\Api\Attribute\Serializable;

#[Attribute(Attribute::TARGET_METHOD)]
class ActionMeta
{

    /**
     * @param array $metadata
     */
    public function __construct(
        #[Serializable] private array $metadata = []
    ){
    }

    /**
     * Get metadata
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Set metadata
     *
     * @param array $metadata
     * @return void
     */
    public function setMetadata(array $metadata): void
    {
        $this->metadata = $metadata;
    }

}