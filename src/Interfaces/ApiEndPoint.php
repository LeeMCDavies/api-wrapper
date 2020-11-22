<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 13/09/2020
 * Time: 18:31
 */

namespace Pecyn\ApiWrapper\Interfaces;

interface ApiEndPoint
{

    public function getMethod(): string;

    public function getUri(): string;

    public function getOptions(): array;

    public function processResponse(\Psr\Http\Message\ResponseInterface $response);
}
