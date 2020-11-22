<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 08:47
 */

namespace Pecyn\ApiWrapper\Interfaces;

use Psr\Http\Message\RequestInterface;

interface RequestMiddleware
{
    public function __invoke(RequestInterface $request): RequestInterface;

    public function __toString();
}
