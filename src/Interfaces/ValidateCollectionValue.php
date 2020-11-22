<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 23/09/2020
 * Time: 09:38
 */

namespace Pecyn\ApiWrapper\Interfaces;

interface ValidateCollectionValue
{
    public function validate($value): bool;
}
