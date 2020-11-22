<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 14:18
 */
namespace Pecyn\ApiWrapper\Tests\EndPoints;

use Pecyn\ApiWrapper\EndPoint;

class TestEndPoint Extends EndPoint
{
    //public function __construct(int $num){}


    public function processResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        return;
    }
}