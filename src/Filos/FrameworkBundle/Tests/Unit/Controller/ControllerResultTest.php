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
