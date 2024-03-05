<?php

namespace App\Services\OrderService\Libraries;

class ArrayOptions
{
    public static function pushToItems(array &$parameters, array $add): void
    {
        foreach ($parameters as &$parameter) {
            $parameter = array_merge($parameter, $add);
        }
    }
}
