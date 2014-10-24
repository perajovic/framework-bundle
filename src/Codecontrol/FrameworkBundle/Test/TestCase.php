<?php

namespace Codecontrol\FrameworkBundle\Test;

use \PHPUnit_Framework_TestCase as PHPUnit_Framework_TestCase;
use \ReflectionClass as ReflectionClass;
use \ReflectionObject as ReflectionObject;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
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
}
