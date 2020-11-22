<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 25/09/2020
 * Time: 09:46
 */

namespace Pecyn\ApiWrapper\Tests\Unit;

use Pecyn\ApiWrapper\Api;
use Pecyn\ApiWrapper\Collections\RequestCollection;
use Pecyn\ApiWrapper\Collections\ResponseCollection;
use Pecyn\ApiWrapper\Exceptions\InvalidCollectionValue;
use Pecyn\ApiWrapper\HttpFactory;
use Pecyn\ApiWrapper\Interfaces\RequestMiddleware;
use Pecyn\ApiWrapper\Interfaces\ResponseMiddleware;
use Pecyn\ApiWrapper\Tests\BaseTest;

class MiddlewareTest extends BaseTest
{

    public function testAddingMiddleware()
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->once()->withArgs(function ($array, $response, $request) {
            return empty($array) && count($request) == 0 && count($response) == 0;
        })->andReturn($client);
        $api = new Api([
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $api->testCase->make([], new HttpFactory());
    }


    public function testAddingApiMiddleware()
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->once()->withArgs(function ($array, $request, $response) {
            return count($array) == 1 && count($request) == 1 && count($response) == 1;
        })->andReturn($client);
        $api = new Api([
            'test'                 => 1,
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $request = \Mockery::mock(RequestMiddleware::class);
        $response = \Mockery::mock(ResponseMiddleware::class);
        $api->addRequestMiddleware($request);
        $api->addResponseMiddleware($response);
        $api->testCase->make([], new HttpFactory());
    }

    public function testAddingEndpointMiddleware()
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->once()->withArgs(function ($array, $request, $response) {
            return count($array) == 1 && count($request) == 1 && count($response) == 1;
        })->andReturn($client);
        $api = new Api([
            'test'                 => 1,
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $api->test->Middleware();
    }

    public function testAddingApiAndEndpointMiddleware()
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->once()->withArgs(function ($array, $request, $response) {
            return count($array) == 1 && count($request) == 2 && count($response) == 2;
        })->andReturn($client);
        $api = new Api([
            'test'                 => 1,
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $request = \Mockery::mock(RequestMiddleware::class);
        $response = \Mockery::mock(ResponseMiddleware::class);
        $api->addRequestMiddleware($request);
        $api->addResponseMiddleware($response);
        $api->test->Middleware();
    }

    public function testAddingInvalidRequestMiddleware()
    {
        $api = new Api([
            'test'                 => 1,
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints']
        ]);
        $response = \Mockery::mock(ResponseMiddleware::class);
        $this->expectException(\TypeError::class);
        $api->addRequestMiddleware($response);
        $api->test();
    }

    public function testAddingInvalidResponseMiddleware()
    {
        $api = new Api([
            'test'                 => 1,
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints']
        ]);
        $request = \Mockery::mock(RequestMiddleware::class);
        $this->expectException(\TypeError::class);
        $api->addResponseMiddleware($request);
        $api->test();
    }

    public function testAddingInvalidObjectToRequestCollection()
    {
        $request = \Mockery::mock(ResponseMiddleware::class);
        $this->expectException(InvalidCollectionValue::class);
        $collection = new RequestCollection();
        $collection[] = $request;
    }

    public function testAddingInvalidObjectToResponseCollection()
    {
        $response = \Mockery::mock(RequestMiddleware::class);
        $this->expectException(InvalidCollectionValue::class);
        $collection = new ResponseCollection();
        $collection[] = $response;
    }

}