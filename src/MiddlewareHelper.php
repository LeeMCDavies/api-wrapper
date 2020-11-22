<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 09:48
 */

namespace Pecyn\ApiWrapper;

use Pecyn\ApiWrapper\Collections\RequestCollection;
use Pecyn\ApiWrapper\Collections\ResponseCollection;
use Pecyn\ApiWrapper\Interfaces\RequestMiddleware;
use Pecyn\ApiWrapper\Interfaces\ResponseMiddleware;

trait MiddlewareHelper
{
    protected $responseMiddleware;
    protected $requestMiddleware;

    public function addRequestMiddleware(RequestMiddleware $request)
    {
        if (!$this->requestMiddleware) {
            $this->requestMiddleware = new RequestCollection();
        }
        $this->requestMiddleware[] = $request;
    }

    public function addResponseMiddleware(ResponseMiddleware $response)
    {
        if (!$this->responseMiddleware) {
            $this->responseMiddleware = new ResponseCollection();
        }
        $this->responseMiddleware[] = $response;
    }

    public function getRequestMiddleware(): RequestCollection
    {
        if (!$this->requestMiddleware) {
            return new RequestCollection();
        }
        return $this->requestMiddleware;
    }

    public function getResponseMiddleware(): ResponseCollection
    {
        if (!$this->responseMiddleware) {
            return new ResponseCollection();
        }
        return $this->responseMiddleware;
    }
}
