<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 09:16
 */

namespace Pecyn\ApiWrapper\Interfaces;

use Pecyn\ApiWrapper\Collections\RequestCollection;
use Pecyn\ApiWrapper\Collections\ResponseCollection;

interface HttpFactory
{
    public function getClient(array $options, RequestCollection $requests, ResponseCollection $responses): HttpClient;
}
