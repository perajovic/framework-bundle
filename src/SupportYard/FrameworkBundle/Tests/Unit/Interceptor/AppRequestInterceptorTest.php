<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Interceptor;

use SupportYard\FrameworkBundle\Interceptor\AppRequestInterceptor;
use SupportYard\FrameworkBundle\Test\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AppRequestInterceptorTest extends TestCase
{
    /**
     * @test
     */
    public function interceptorImplementsInterface()
    {
        $this->assertInstanceOf(
            'SupportYard\FrameworkBundle\Interceptor\InterceptorInterface',
            $this->interceptor
        );
    }

    /**
     * @test
     * @expectedException Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage Some error
     */
    public function ifAppRequestIsNotValidExceptionIsThrown()
    {
        $this->ensureFieldsArePopulated();
        $this->ensureAppRequestStatus(false);
        $this->ensureAppRequestError('Some error');

        $this->interceptor->apply($this->request);
    }

    /**
     * @test
     */
    public function interceptorIsApplied()
    {
        $this->ensureFieldsArePopulated();
        $this->ensureAppRequestStatus(true);

        $this->interceptor->apply($this->request);

        $this->assertSame(
            $this->appRequest,
            $this->request->attributes->get('appRequest')
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->appRequest = $this->createAppRequest();
        $this->request = Request::create('/_interceptor_test');
        $this->interceptor = new AppRequestInterceptor($this->appRequest);
    }

    private function ensureAppRequestError($error)
    {
        $this
            ->appRequest
            ->expects($this->once())
            ->method('getFlattenErrors')
            ->will($this->returnValue($error));
    }

    private function ensureAppRequestStatus($isValid)
    {
        $this
            ->appRequest
            ->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue($isValid));
    }

    private function ensureFieldsArePopulated()
    {
        $this
            ->appRequest
            ->expects($this->once())
            ->method('populateFields')
            ->with($this->request);
    }

    private function createAppRequest()
    {
        return $this->createMockFor(
            'SupportYard\FrameworkBundle\Request\AppRequestInterface'
        );
    }
}
