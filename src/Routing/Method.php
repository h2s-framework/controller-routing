<?php

namespace Siarko\ActionRouting\Routing;

use Siarko\ActionRouting\Routing\Exceptions\UnknownHttpMethodException;

enum Method
{
    case POST;
    case GET;
    case HEAD;
    case PUT;
    case DELETE;
    case CONNECT;
    case OPTIONS;
    case TRACE;
    case PATCH;

    public static function all(): array
    {
        return self::cases();
    }

    public static function fromString(string $name): Method
    {
        $name = strtoupper($name);
        foreach (Method::cases() as $item) {
            if($name == $item->name){
                return $item;
            }
        }
        throw new UnknownHttpMethodException($name);
    }
}