<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\TestCase;

use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    use TestCaseTrait;

    protected function tearDown()
    {
        $this->nullifyProperties();

        parent::tearDown();
    }

    protected function createMockFor(string $class, array $methods = []): PHPUnit_Framework_MockObject_MockObject
    {
        return $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }
}
