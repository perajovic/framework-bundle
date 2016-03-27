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

use Exception;
use Filos\FrameworkBundle\Controller\ExceptionController;
use Filos\FrameworkBundle\Test\TestCase;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
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

        $twigLoaderFilesystem = new Twig_Loader_Filesystem();
        $twigLoaderFilesystem->setPaths(__DIR__.'/../../Fixture/views', 'Twig');
        $twigEnvironment = new Twig_Environment($twigLoaderFilesystem);

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

        $this->assertSame(502, $response->getStatusCode());
        $this->assertTrue($response->headers->get('X-Error-Handled'));
    }
}
