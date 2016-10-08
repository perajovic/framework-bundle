<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Controller;

use Exception;
use Filos\FrameworkBundle\Controller\ExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;
use Twig_Environment;
use Twig_Loader_Filesystem;

class ExceptionControllerTest extends TestCase
{
    /**
     * @var ExceptionController
     */
    private $controller;

    /**
     * @var Request
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $twigLoader = new Twig_Loader_Filesystem();
        $twigLoader->setPaths(__DIR__.'/../Fixture/views', 'Twig');
        $twigEnvironment = new Twig_Environment($twigLoader);

        $this->request = Request::createFromGlobals();
        $this->controller = new ExceptionController($twigEnvironment);
    }

    /**
     * @test
     */
    public function showAction()
    {
        $flattenException = FlattenException::create(new Exception('Test error.'), 502);

        $response = $this->controller->showAction($this->request, $flattenException);

        $this->assertSame("Test error template\n", $response->getContent());
        $this->assertSame(502, $response->getStatusCode());
        $this->assertTrue($response->headers->get('X-Error-Handled'));
    }
}
