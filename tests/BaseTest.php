<?php
/**
 * Created by PhpStorm
 * User: lee
 * Date: 25/09/2020
 * Time: 09:47
 */

namespace Pecyn\ApiWrapper\Tests;


class BaseTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown(): void
    {

        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }
        \Mockery::close();
        parent::tearDown();
    }
}