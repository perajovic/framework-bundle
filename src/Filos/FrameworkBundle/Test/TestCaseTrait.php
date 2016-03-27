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

namespace Filos\FrameworkBundle\Test;

use ReflectionClass;
use ReflectionObject;

trait TestCaseTrait
{
    /**
     * @param object $obj
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    protected function callNonPublicMethodWithArguments(
        $obj,
        $method,
        array $arguments = []
    ) {
        return $this
            ->setClassMemberAsAccessible($obj, $method, 'method')
            ->invokeArgs($obj, $arguments);
    }

    /**
     * @param mixed  $obj
     * @param string $property
     * @param mixed  $value
     *
     * @return mixed
     */
    protected function setNonPublicPropertyValue($obj, $property, $value)
    {
        $this
            ->setClassMemberAsAccessible($obj, $property, 'property')
            ->setValue($obj, $value);
    }

    /**
     * @param mixed  $obj
     * @param string $property
     *
     * @return mixed
     */
    protected function getNonPublicPropertyValue($obj, $property)
    {
        return $this
            ->setClassMemberAsAccessible($obj, $property, 'property')
            ->getValue($obj);
    }

    /**
     * @param mixed  $classOrObj
     * @param string $member
     * @param string $type
     *
     * @return mixed
     */
    protected function setClassMemberAsAccessible($classOrObj, $member, $type)
    {
        $class = is_object($classOrObj) ? get_class($classOrObj) : $classOrObj;
        $method = 'method' === $type ? 'getMethod' : 'getProperty';

        $member = (new ReflectionClass($class))->{$method}($member);
        $member->setAccessible(true);

        return $member;
    }

    private function nullifyProperties()
    {
        $rObj = new ReflectionObject($this);

        foreach ($rObj->getProperties() as $property) {
            if (!$property->isStatic() && 0
                !== strpos($property->getDeclaringClass()->getName(), 'PHPUnit_')
            ) {
                $property->setAccessible(true);
                $property->setValue($this, null);
            }
        }
    }
}
