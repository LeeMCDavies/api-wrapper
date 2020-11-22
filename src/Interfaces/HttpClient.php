<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 12/09/2020
 * Time: 07:58
 */

namespace Pecyn\ApiWrapper\Interfaces;

interface HttpClient
{
    public function dispatch(ApiEndpoint $endpoint);
}
