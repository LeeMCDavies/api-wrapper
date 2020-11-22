<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 13:49
 */

namespace Pecyn\ApiWrapper\Tests\Unit;

use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Pecyn\ApiWrapper\Api;
use Pecyn\ApiWrapper\Exceptions\EndPointClassException;
use Pecyn\ApiWrapper\Exceptions\EndPointClassNotFoundException;
use Pecyn\ApiWrapper\Exceptions\EndPointRequestException;
use Pecyn\ApiWrapper\HttpFactory;
use Pecyn\ApiWrapper\Tests\BaseTest;
use Pecyn\ApiWrapper\Tests\EndPoints\TestCaseMakeEndPoint;
use Pecyn\ApiWrapper\Tests\EndPoints\TestEndPoint;

class ApiTest extends BaseTest
{
    protected $api;

    /**
     * @dataProvider  validEndPointProvider
     */
    public function testValidEndPointResolution(\closure $method, string $class)
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->andReturn($client);
        $client->shouldReceive('dispatch')->once()->with(anInstanceOf($class));
        $api = new Api([
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $method($api);
    }


    public function testMultiCallEndPointResolution()
    {
        $client = \Mockery::spy(\Pecyn\ApiWrapper\HttpClient::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->times(2)->andReturn($client);
        $client->shouldReceive('dispatch')->times(2)->with(anInstanceOf(TestCaseMakeEndPoint::class));
        $api = new Api([
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $api->testCase->make([], new HttpFactory());
        $api->testCase->make([], new HttpFactory());
    }


    public function testHandleGuzzleException()
    {
        $http = \Mockery::mock(\GuzzleHttp\ClientInterface::class);
        $client = \Mockery::mock(\Pecyn\ApiWrapper\HttpClient::class, [$http])->makePartial();
        $ex = \Mockery::mock(BadResponseException::class . "," . ResponseInterface::class);
        $factory = \Mockery::mock(HttpFactory::class, \Pecyn\ApiWrapper\Interfaces\HttpFactory::class);
        $factory->shouldReceive('getClient')->once()->andReturn($client);
        $api = new Api([
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints'], 'http_factory' => $factory
        ]);
        $http->shouldReceive('request')->andThrow($ex);
        $this->expectException(EndPointRequestException::class);
        $api->testCase->make([], new HttpFactory());
    }

    public function validEndPointProvider()
    {
        return [
            'Endpoint no construct args'                 => [
                function ($api) {
                    $api->test();
                }, TestEndPoint::class
            ],
            'Endpoint with construct args'               => [
                function ($api) {
                    $api->testCaseMake([], new HttpFactory());
                }, TestCaseMakeEndPoint::class
            ],
            'Endpoint with alternative calling example'  => [
                function ($api) {
                    $api->test->caseMake([], new HttpFactory());
                }, TestCaseMakeEndPoint::class
            ],
            'Endpoint with alternative calling example2' => [
                function ($api) {
                    $api->test->case->make([], new HttpFactory());
                }, TestCaseMakeEndPoint::class
            ],
            'Endpoint with alternative calling example3' => [
                function ($api) {
                    $api->testCase->make([], new HttpFactory());
                }, TestCaseMakeEndPoint::class
            ]
        ];
    }

    /**
     * @dataProvider  endPointExceptionProvider
     */
    public function testEndPointException(\closure $method, string $exception)
    {

        $this->expectException($exception);
        $api = new Api([
            'end_point_namespaces' => ['Pecyn\\ApiWrapper\\Tests\\EndPoints']
        ]);
        $method($api);
    }

    public function endPointExceptionProvider()
    {
        return [
            'Endpoint does not exist'                                 => [
                function ($api) {
                    $api->test->make([], new HttpFactory());
                }, EndPointClassNotFoundException::class
            ],
            'Endpoint exists, wrong naming convention'                => [
                function ($api) {
                    $api->testcase->make([], new HttpFactory());
                }, EndPointClassNotFoundException::class
            ],
            'Endpoint exists, does not implement end point interface' => [
                function ($api) {
                    $api->testInterface();
                }, EndPointClassNotFoundException::class
            ],
            'Endpoint exists, wrong args'                             => [
                function ($api) {
                    $api->testCase->make("fail", new HttpFactory());
                }, EndPointClassException::class
            ],
        ];
    }


}