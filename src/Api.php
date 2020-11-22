<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 13/09/2020
 * Time: 19:07
 */

namespace Pecyn\ApiWrapper;

use Pecyn\ApiWrapper\Exceptions\EndPointClassException;
use Pecyn\ApiWrapper\Exceptions\EndPointClassNotFoundException;
use Pecyn\ApiWrapper\Interfaces\ApiEndPoint;
use Pecyn\ApiWrapper\Interfaces\HasMiddleware;

class Api implements HasMiddleware
{
    use FactoryHelper, MiddlewareHelper;

    protected $parts = [];
    protected $endPointNameSpaces = [];
    protected $defaultFactory = HttpFactory::class;
    protected $config;
    protected $endPoint;

    public function __construct(array $config = [])
    {
        if (array_key_exists('end_point_namespaces', $config) && is_array($config['end_point_namespaces'])) {
            $this->endPointNameSpaces = $config['end_point_namespaces'];
            unset($config['end_point_namespaces']);
        }
        if (array_key_exists('http_factory', $config)) {
            $this->setFactory($config['http_factory']);
            unset($config['http_factory']);
        } else {
            $this->setFactory($this->defaultFactory::make());
        }

        $this->config = $config;
    }

    /**
     * @param array $endPointNameSpaces
     */
    public function setEndPointNameSpaces(array $endPointNameSpaces): void
    {
        $this->endPointNameSpaces = $endPointNameSpaces;
    }

    public function __get($name)
    {
        $this->parts[] = $name;
        return $this;
    }

    /**
     * Build the endpoint class and make request;
     *
     * @param $name
     * @param $arguments
     * @return \Exception
     */
    public function __call($name, $arguments)
    {
        try {
            $class = $this->getClass($name);
            $reflection_class = new \ReflectionClass($class);
            //Force case sensitive
            if ($reflection_class->getName() !== $class) {
                throw new EndPointClassNotFoundException('Unable to find end point class', 200);
            }
            $ob =  $reflection_class->newInstanceArgs($arguments);
            $ob->setFactory($this->factory);
            $this->endPoint = $ob;
            $httpClient = $this->factory->getClient($this->config, $this->generateRequestMiddleware($ob), $this->generateResponseMiddleware($ob));
            $httpClient->setFactory($this->factory);
            return $httpClient->dispatch($ob);
        } catch (\ReflectionException $e) {
            throw new EndPointClassException('Problem instantiating end point class: ' . $class, 101, $e);
        } catch (\TypeError $e) {
            throw new EndPointClassException('Problem instantiating end point class: ' . $class, 102, $e);
        }
    }

    protected function generateRequestMiddleware(ApiEndPoint $endpoint)
    {
        $request = $endpoint->getRequestMiddleware();
        foreach ($request as $ob) {
            $this->addRequestMiddleware($ob);
        }
        return $this->getRequestMiddleware();
    }

    protected function generateResponseMiddleware(ApiEndPoint $endpoint)
    {
        $request = $endpoint->getResponseMiddleware();
        foreach ($request as $ob) {
            $this->addResponseMiddleware($ob);
        }
        return $this->getResponseMiddleware();
    }

    /**
     * Build the endpoint class name
     *
     * @param $name
     * @return string
     */
    protected function getClass($name)
    {
        $parts = array_map('ucfirst', $this->parts);
        $this->parts = [];
        $classParts = [ucfirst($name), 'EndPoint'];
        if (count($parts)) {
            array_push($parts, $classParts[0], $classParts[1]);
            $classParts = $parts;
        }
        $className = implode('', $classParts);
        foreach ($this->endPointNameSpaces as $path) {
            $class = $path . '\\' . $className;
            if (class_exists($class) && array_key_exists(ApiEndpoint::class, class_implements($class))) {
                return $class;
            }
        }
        throw new EndPointClassNotFoundException('Unable to find end point class', 103);
    }
}
