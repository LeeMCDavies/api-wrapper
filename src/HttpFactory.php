<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 09:17
 */

namespace Pecyn\ApiWrapper;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Pecyn\ApiWrapper\Collections\RequestCollection;
use Pecyn\ApiWrapper\Collections\ResponseCollection;

class HttpFactory implements Interfaces\HttpFactory
{
    /**
     * Build a http client to process requests
     *
     * @param array $options
     * @param RequestCollection $requests
     * @param ResponseCollection $responses
     * @return Interfaces\HttpClient
     */
    public function getClient(array $options, RequestCollection $requests, ResponseCollection $responses): \Pecyn\ApiWrapper\Interfaces\HttpClient
    {
        $stack = HandlerStack::create();
        foreach ($requests->uniqueValues() as $key => $ob) {
            $stack->push(Middleware::mapRequest($ob));
        }
        foreach ($responses->uniqueValues() as $ob) {
            $stack->push(Middleware::mapResponse($ob));
        }
        $options['handler'] = $stack;
        return new HttpClient(new Client($options));
    }

    /**
     * Create a HttpFactory instance
     *
     * @return Interfaces\HttpFactory
     */
    public static function make(): Interfaces\HttpFactory
    {
        return new static();
    }
}
