<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 14:18
 */
namespace Pecyn\ApiWrapper\Tests\EndPoints;

use Pecyn\ApiWrapper\EndPoint;
use Pecyn\ApiWrapper\Interfaces\RequestMiddleware;
use Pecyn\ApiWrapper\Interfaces\ResponseMiddleware;

class TestMiddlewareEndPoint Extends EndPoint
{
    //public function __construct(int $num){}

    public function __construct()
    {

        $this->addRequestMiddleware(\Mockery::mock(RequestMiddleware::class));
        $this->addResponseMiddleware(\Mockery::mock(ResponseMiddleware::class));
    }

    public function processResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        return;
    }
}