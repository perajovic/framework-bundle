<?php

namespace Codecontrol\FrameworkBundle\Test;

use Symfony\Component\HttpFoundation\Request;

abstract class AppRequestTestCase extends FunctionalTestCase
{
    protected $appRequest;

    protected $httpMethod = 'POST';

    /**
     * @test
     */
    public function requestImplementsInterface()
    {
        $this->assertInstanceOf(
            'Codecontrol\FrameworkBundle\Request\AppRequestInterface',
            $this->appRequest
        );
    }

    /**
     * @test
     * @dataProvider provideDataForInvalidRequest
     */
    public function requestIsNotValid(
        array $requestParams = [],
        array $errors = [],
        $flattenErrors = null
    ) {
        $this->populateFields($requestParams);

        $this->assertFalse($this->appRequest->isValid());
        $this->assertEquals($errors, $this->appRequest->getErrors());
        $this->assertEquals($flattenErrors, $this->appRequest->getFlattenErrors());
    }

    /**
     * @test
     * @dataProvider provideDataForValidRequest
     */
    public function requestIsValid(
        array $requestParams = [],
        array $expected = []
    ) {
        $this->populateFields($requestParams);

        foreach ($expected as $field => $value) {
            $getterMethod = sprintf('get%s', ucfirst($field));
            $this->assertSame(
                $expected[$field],
                $this->appRequest->{$getterMethod}()
            );
        }

        $this->assertTrue($this->appRequest->isValid());
        $this->assertSame([], $this->appRequest->getErrors());
        $this->assertSame('', $this->appRequest->getFlattenErrors());
    }

    protected function populateFields(array $params)
    {
        $this->appRequest->populateFields(
            Request::create('/_app_request_test', $this->httpMethod, $params)
        );
    }
}
