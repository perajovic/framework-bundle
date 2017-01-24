<?php


/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */
declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\EventListener;

use Filos\FrameworkBundle\EventListener\JsonRequestListener;
use Filos\FrameworkBundle\TestCase\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Tests\Filos\FrameworkBundle\Fixture\AppKernel;

class JsonRequestListenerTest extends TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var JsonRequestListener
     */
    private $listener;

    /**
     * @var AppKernel
     */
    private $kernel;

    protected function setUp()
    {
        parent::setUp();

        $this->kernel = new AppKernel('test', true);
        $this->request = Request::create('/_listener');
        $this->listener = new JsonRequestListener();
    }

    /**
     * @test
     */
    public function listenerIsStoppedForSubRequest()
    {
        $event = $this->createGetResponseEvent(HttpKernelInterface::SUB_REQUEST);

        $this->listener->onKernelRequest($event);

        $this->assertSame('html', $this->request->getRequestFormat());
    }

    /**
     * @test
     */
    public function ifContentTypeIsDifferentFromJsonRequestContentTransformationIsSkipped()
    {
        $event = $this->createGetResponseEvent(HttpKernelInterface::MASTER_REQUEST);

        $this->listener->onKernelRequest($event);

        $this->setNonPublicPropertyValue($this->request, 'content', '{"foo":"bar"}');

        $this->assertSame('{"foo":"bar"}', $this->request->getContent());
    }

    /**
     * @test
     *
     * @dataProvider provideJsonValues
     */
    public function ifContentTypeIsJsonRequestContentIsTransformed(array $requestPayload, string $content)
    {
        $event = $this->createGetResponseEvent(HttpKernelInterface::MASTER_REQUEST);

        $this->request->headers->set('CONTENT_TYPE', 'application/json');
        $this->setNonPublicPropertyValue($this->request, 'content', $content);

        $this->listener->onKernelRequest($event);

        $this->assertSame($requestPayload, $this->request->request->all());
    }

    public function provideJsonValues(): array
    {
        return [
            [['foo' => 'bar'], '{"foo":"bar"}'],
            [[], 'plain text'],
        ];
    }

    private function createGetResponseEvent(int $requestType): GetResponseEvent
    {
        return new GetResponseEvent($this->kernel, $this->request, $requestType);
    }
}
