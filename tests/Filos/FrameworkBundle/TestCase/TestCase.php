<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Tests\Filos\FrameworkBundle\TestCase;

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
