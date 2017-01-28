<?php 

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Controller;

use Filos\FrameworkBundle\Controller\UrlCatcherController;
use Filos\FrameworkBundle\TestCase\TestCase;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class UrlCatcherControllerTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    protected function setUp()
    {
        parent::setUp();

        $this->router = $this->createMockFor(Router::class);
    }

    /**
     * @test
     */
    public function redirectResponseIsCreatedForNonEmptyRoute()
    {
        $urlCatcherController = new UrlCatcherController($this->router, 'default_route');

        $this
            ->router
            ->expects($this->once())
            ->method('generate')
            ->with('default_route')
            ->will($this->returnValue('/default-route'));

        $response = $urlCatcherController->indexAction();

        $this->assertSame('/default-route', $response->getTargetUrl());
    }

    /**
     * @test
     */
    public function redirectResponseIsCreatedForEmptyRoute()
    {
        $urlCatcherController = new UrlCatcherController($this->router, '');

        $response = $urlCatcherController->indexAction();

        $this->assertSame('/', $response->getTargetUrl());
    }
}
