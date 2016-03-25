<?php

namespace Filos\FrameworkBundle\Tests\Unit\Controller;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Filos\FrameworkBundle\Test\TestCase;

class ControllerResultTest extends TestCase
{
    /**
     * @test
     */
    public function checkInitialState()
    {
        $result = new ControllerResult();

        $this->assertEmpty($result->view->all());
        $this->assertEmpty($result->app->all());
    }

    /**
     * @test
     */
    public function propertiesAreParameterBagInstances()
    {
        $result = new ControllerResult();

        $this->assertInstanceOf(
            'Symfony\Component\HttpFoundation\ParameterBag',
            $result->view
        );
        $this->assertInstanceOf(
            'Symfony\Component\HttpFoundation\ParameterBag',
            $result->view
        );
    }

    /**
     * @test
     */
    public function propertiesAreSettledAndRetrieved()
    {
        $result = new ControllerResult(['foo' => 'bar'], ['bar' => 'baz']);

        $this->assertSame('bar', $result->view->get('foo'));
        $this->assertSame('baz', $result->app->get('bar'));
    }
}
