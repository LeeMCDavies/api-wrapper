<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 11/09/2020
 * Time: 13:22
 */

namespace Pecyn\ApiWrapper;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Pecyn\ApiWrapper\Exceptions\EndPointRequestException;
use Pecyn\ApiWrapper\Interfaces\ApiEndpoint;
use Pecyn\ApiWrapper\Interfaces\HttpClient as HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    use FactoryHelper;

    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Build and make request
     *
     * @param ApiEndpoint $apiEndpoint
     */
    public function dispatch(ApiEndpoint $apiEndpoint)
    {
        try {
            $response = $this->client->request($apiEndpoint->getMethod(), $apiEndpoint->getUri(), $apiEndpoint->getOptions());
            return $apiEndpoint->processResponse($response);
        } catch (GuzzleException $e) {
            throw new EndPointRequestException('Problem making request: ' . $apiEndpoint->getMethod().' '.$apiEndpoint->getUri(), '300', $e);
        } catch (\Exception $e){
            throw new EndPointRequestException('Problem making request: ' . $apiEndpoint->getMethod().' '.$apiEndpoint->getUri(), '301', $e);
        }
    }
}
