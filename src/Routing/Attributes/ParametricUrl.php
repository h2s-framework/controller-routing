<?php

namespace Siarko\ActionRouting\Routing\Attributes;

use Attribute;
use Siarko\ActionRouting\Routing\Method;
use Siarko\Serialization\Api\Attribute\Serializable;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ParametricUrl
{

    /**
     * @var Method[]
     */
    #[Serializable]
    protected array $methods = [];

    public function __construct(
        #[Serializable] private readonly ?string $pattern = null,
        Method|array $methods = Method::GET
    ){
        if($methods instanceof Method){
            $methods = [$methods];
        }
        $this->methods = $methods;
    }

    /**
     * @return string|null
     */
    public function getPattern(): ?string
    {
        if($this->pattern != null){
            return str_replace('%', '$', $this->pattern);
        }
        return null;
    }

    /**
     * @param Method $method
     * @return bool
     */
    public function matchesMethod(Method $method): bool
    {
        return in_array($method, $this->methods);
    }

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}