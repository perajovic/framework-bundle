<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\TestCase;

use PHPUnit_Framework_TestCase;

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
     * @return \PHPUnit_Framework_MockObject_MockObject
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
