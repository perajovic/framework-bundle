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
use ReflectionClass;
use ReflectionObject;

trait TestCaseTrait
{
    /**
     * @return mixed
     */
    protected function callNonPublicMethodWithArguments($obj, string $method, array $arguments = [])
    {
        return $this
            ->setClassMemberAsAccessible($obj, $method, 'method')
            ->invokeArgs($obj, $arguments);
    }

    protected function setNonPublicPropertyValue($obj, string $property, $value)
    {
        $this
            ->setClassMemberAsAccessible($obj, $property, 'property')
            ->setValue($obj, $value);
    }

    /**
     * @return mixed
     */
    protected function getNonPublicPropertyValue($obj, string $property)
    {
        return $this
            ->setClassMemberAsAccessible($obj, $property, 'property')
            ->getValue($obj);
    }

    /**
     * @return mixed
     */
    protected function setClassMemberAsAccessible($classOrObj, string $member, string $type)
    {
        $class = is_object($classOrObj) ? get_class($classOrObj) : $classOrObj;

        if ('method' === $type) {
            $member = (new ReflectionClass($class))->getMethod($member);
        } else {
            $member = (new ReflectionClass($class))->getProperty($member);
        }

        $member->setAccessible(true);

        return $member;
    }

    protected function nullifyProperties()
    {
        $rObj = new ReflectionObject($this);

        foreach ($rObj->getProperties() as $property) {
            if (!$property->isStatic() && 0 !== strpos($property->getDeclaringClass()->getName(), 'PHPUnit_')) {
                $property->setAccessible(true);
                $property->setValue($this, null);
            }
        }
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
