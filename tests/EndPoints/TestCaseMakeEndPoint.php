<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 14:18
 */
namespace Pecyn\ApiWrapper\Tests\EndPoints;

use Pecyn\ApiWrapper\EndPoint;
use Pecyn\ApiWrapper\Interfaces\HttpFactory;

class TestCaseMakeEndPoint Extends EndPoint
{
    protected $method = "GET";
    protected $uri = "http://test.com";
    public function __construct(array $options, HttpFactory $factory){}


    public function processResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        return;
    }
}