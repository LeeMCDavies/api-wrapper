<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 09:37
 */
namespace Pecyn\ApiWrapper\Collections;

use Pecyn\ApiWrapper\Interfaces\ResponseMiddleware;
use Pecyn\ApiWrapper\Collection;

class ResponseCollection extends Collection
{
    public function validate($value): bool
    {
        if (is_object($value) && array_key_exists(ResponseMiddleware::class, class_implements($value))) {
            return true;
        }
        return false;
    }
}
