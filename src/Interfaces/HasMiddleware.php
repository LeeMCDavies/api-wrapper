<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 08:46
 */

namespace Pecyn\ApiWrapper\Interfaces;

use Pecyn\ApiWrapper\Collections\RequestCollection;
use Pecyn\ApiWrapper\Collections\ResponseCollection;

interface HasMiddleware
{
    public function getRequestMiddleware(): RequestCollection;

    public function getResponseMiddleware(): ResponseCollection;

    public function addRequestMiddleware(RequestMiddleware $request);

    public function addResponseMiddleware(ResponseMiddleware $request);
}
