<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 09:37
 */
namespace Pecyn\ApiWrapper\Collections;

use Pecyn\ApiWrapper\Collection;
use Pecyn\ApiWrapper\Interfaces\RequestMiddleware;

class RequestCollection extends Collection
{
    public function validate($value): bool
    {
        if (is_object($value) && array_key_exists(RequestMiddleware::class, class_implements($value))) {
            return true;
        }
        return false;
    }
}
