<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 08:47
 */

namespace Pecyn\ApiWrapper\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ResponseMiddleware
{
    public function __invoke(ResponseInterface $response): ResponseInterface;

    public function __toString();
}
