<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 13/09/2020
 * Time: 18:34
 */

namespace Pecyn\ApiWrapper;

use Pecyn\ApiWrapper\Interfaces\ApiEndPoint;
use Pecyn\ApiWrapper\Interfaces\HasMiddleware;

abstract class EndPoint implements ApiEndPoint, HasMiddleware
{
    use FactoryHelper, MiddlewareHelper;

    protected $options = [];
    protected $method;
    protected $uri;

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return mixed
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}
