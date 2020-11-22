# PHP API Wrapper

Simple package to help generate a API wrapper.

###Installation

composer require pecyn/api-wrapper

###Usage

Create class to represent your api.
```
<?php

namespace Api\EndPoints\Users;

use Psr\Http\Message\ResponseInterface;
use Pecyn\ApiWrapper\EndPoint;
use Api\Models\User

class UsersGetEndPoint extends EndPoint
{
    protected $method = 'GET';
    protected $uri = 'http//api.com/users';
    
    public function __construct(int $userId)
    {
        $this->uri = $this->uri . '/' . $userId;
    }

    public function processResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() == 200) {
            return User::fromJson($response->getBody());
        }
    }
}
```
Create an api instance
```
<?php

use Pecyn\ApiWrapper\Api;

$api = new Api(['end_point_namespaces' => ['EndPoints\\Users']]);
//or
$api = new Api()->setEndPointNameSpaces(['EndPoints\\Users']);
//or extend the Api class.
//class MyApi Extends Api{
//
//protected $endPointNameSpaces = ['EndPoints\\Users'];
//      

$user = $api->users->get(9);
```
