<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 15/09/2020
 * Time: 09:42
 */

namespace Pecyn\ApiWrapper;

trait FactoryHelper
{
    protected $factory;

    public function setFactory(\Pecyn\ApiWrapper\Interfaces\HttpFactory $factory)
    {
        $this->factory = $factory;
    }
}
