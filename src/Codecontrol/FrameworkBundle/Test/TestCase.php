<?php

namespace Codecontrol\FrameworkBundle\Test;

use \PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    use TestCaseTrait;

    protected function tearDown()
    {
        $this->nullifyProperties();

        parent::tearDown();
    }

    /**
     * @param string $class
     * @param array  $methods
     *
     * @return object
     */
    protected function createMockFor($class, array $methods = [])
    {
        return $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }
}
