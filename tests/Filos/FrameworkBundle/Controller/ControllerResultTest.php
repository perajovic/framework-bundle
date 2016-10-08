<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Controller;

use Filos\FrameworkBundle\Controller\ControllerResult;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class ControllerResultTest extends TestCase
{
    /**
     * @test
     */
    public function checkInitialState()
    {
        $result = new ControllerResult();

        $this->assertCount(0, $result->view->all());
        $this->assertCount(0, $result->app->all());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\ParameterBag', $result->view);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\ParameterBag', $result->app);
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
