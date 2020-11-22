<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 25/09/2020
 * Time: 13:40
 */

namespace Pecyn\ApiWrapper\Interfaces;

interface Collection extends \ArrayAccess, \Countable, \Iterator, ValidateCollectionValue
{
    public function uniqueValues(): array;
}
