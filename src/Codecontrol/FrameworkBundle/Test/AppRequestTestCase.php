<?php

namespace Codecontrol\FrameworkBundle\Test;

use Symfony\Component\HttpFoundation\Request;

abstract class AppRequestTestCase extends FunctionalTestCase
{
    const HTTP_METHOD = 'POST';

    protected $appRequest;

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

        $this->assertAppRequestIsNotValid($errors, $flattenErrors);
    }

    /**
     * @test
     * @dataProvider provideDataForValidRequest
     */
    public function requestIsValid(array $requestParams = [], array $expected = [])
    {
        $this->populateFields($requestParams);

        foreach ($expected as $field => $value) {
            $getterMethod = sprintf('get%s', ucfirst($field));
            if (!method_exists($this->appRequest, $getterMethod)) {
                $getterMethod = sprintf('has%s', ucfirst($field));
            }
            $assertMethod = is_object($expected[$field])
                ? 'assertEquals'
                : 'assertSame';
            $this->{$assertMethod}(
                $expected[$field],
                $this->appRequest->{$getterMethod}()
            );
        }

        $this->assertTrue($this->appRequest->isValid());
        $this->assertSame([], $this->appRequest->getErrors());
        $this->assertSame('', $this->appRequest->getFlattenErrors());
    }

    protected function assertAppRequestIsNotValid(array $errors, $flattenErrors)
    {
        $this->assertFalse($this->appRequest->isValid());
        $this->assertEquals($errors, $this->appRequest->getErrors());
        $this->assertEquals($flattenErrors, $this->appRequest->getFlattenErrors());
    }

    protected function populateFields(array $params)
    {
        if (isset($params['_multiFields']) && $params['_multiFields']) {
            unset($params['_multiFields']);
            $request = Request::create('/_app_request_test', static::HTTP_METHOD);
            foreach ($params as $key => $value) {
                $request->{$key}->replace($value);
            }
        } else {
            $request = Request::create(
                '/_app_request_test',
                static::HTTP_METHOD,
                $params
            );
        }

        $this->appRequest->populateFields($request);
    }
}
