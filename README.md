# PHP API Wrapper

Simple package to help generate a API wrapper.

###Installation

composer require pecyn/api-wrapper

###Usage

Create a class to represent your api.
```
<?php

namespace App\EndPoints;

use Pecyn\ApiWrapper\EndPoint;

class CatsGetEndPoint extends EndPoint
{
    protected $method = 'GET';
    protected $uri = 'https://cat-fact.herokuapp.com/facts';

    public function __construct(string $id)
    {
        $this->uri .= '/' . $id;
    }

    public function processResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        if ($response->getStatusCode() == 200) {
            return $response->getBody();
        }
    }
}
```
Create an api instance
```
<?php

use Pecyn\ApiWrapper\Api;

$api = new \Pecyn\ApiWrapper\Api(['end_point_namespaces' => ['App\EndPoints']]);
//or
$api = new \Pecyn\ApiWrapper\Api();
$api->setEndPointNameSpaces(['App\EndPoints']);
//or extend the Api class.
//class MyApi Extends Api{
//
//protected $endPointNameSpaces = ['App\EndPoints'];
//      

$facts = $api->cats->get('591d9b2f227c1a0020d26823');
```
