<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Request;

use Codecontrol\FrameworkBundle\Tests\Fixtures\InvalidAppRequest;
use Codecontrol\FrameworkBundle\Tests\Fixtures\ValidAppRequest;
use Codecontrol\FrameworkBundle\Test\TestCase;

class AppRequestTest extends TestCase
{
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
     */
    public function checkInitialState()
    {
        $this->assertTrue($this->appRequest->isValid());
        $this->assertEmpty($this->appRequest->getErrors());
        $this->assertSame('', $this->appRequest->getFlattenErrors());
    }

    /**
     * @test
     */
    public function forValidationProcessValidatorIsNotRequired()
    {
        $this->appRequest->isValid();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Property Codecontrol\FrameworkBundle\Tests\Fixtures\InvalidAppRequest::foo doesn't exist.
     */
    public function ifFieldDoesNotExistExceptionIsThrown()
    {
        $appRequest = new InvalidAppRequest($this->adapter);

        $appRequest->isValid();
    }

    /**
     * @test
     */
    public function validationFailed()
    {
        $appRequest = new ValidAppRequest($this->adapter);

        $this->ensureValueIsValidated('foo', 'foo-val', 'foo-error', 0);
        $this->ensureValueIsValidated('bar', 'bar-val', null, 1);
        $this->ensureValueIsValidated('baz', 'baz-val', 'baz-error', 2);
        $this->ensureValueIsValidated('zaz', 1, null, 3);
        $this->ensureValueIsValidated('zaz', '', 'zaz-1-error', 4);
        $this->ensureValueIsValidated('zaz', 'my_value', null, 5);
        $this->ensureValueIsValidated('zaz', null, 'zaz-2-error', 6);
        $this->ensureValueIsValidated('vaz', '', 'vaz-1-error', 7);
        $this->ensureValueIsValidated('vaz', 12, null, 8);
        $this->ensureValueIsValidated('vaz', null, 'vaz-2-error', 9);

        $this->assertFalse($appRequest->isValid());
        $this->assertEquals(
            [
                'foo' => 'foo-error',
                'baz' => 'baz-error',
                'zaz' => [1 => 'zaz-1-error', 3 => 'zaz-2-error'],
                'vaz' => [0 => 'vaz-1-error', 2 => 'vaz-2-error'],
            ],
            $appRequest->getErrors()
        );
        $this->assertSame(
            'foo-error'
                .PHP_EOL.'baz-error'
                .PHP_EOL.'zaz-1-error'
                .PHP_EOL.'zaz-2-error'
                .PHP_EOL.'vaz-1-error'
                .PHP_EOL.'vaz-2-error',
            $appRequest->getFlattenErrors()
        );
    }

    /**
     * @test
     */
    public function validationPassed()
    {
        $appRequest = new ValidAppRequest($this->adapter);

        $this->ensureValueIsValidated('foo', 'foo-val', null, 0);
        $this->ensureValueIsValidated('bar', 'bar-val', null, 1);
        $this->ensureValueIsValidated('baz', 'baz-val', null, 2);
        $this->ensureValueIsValidated('zaz', 1, null, 3);
        $this->ensureValueIsValidated('zaz', '', null, 4);
        $this->ensureValueIsValidated('zaz', 'my_value', null, 5);
        $this->ensureValueIsValidated('zaz', null, null, 6);
        $this->ensureValueIsValidated('vaz', '', null, 7);
        $this->ensureValueIsValidated('vaz', 12, null, 8);
        $this->ensureValueIsValidated('vaz', null, null, 9);

        $this->assertTrue($appRequest->isValid());
        $this->assertEmpty($appRequest->getErrors());
        $this->assertSame('', $appRequest->getFlattenErrors());
    }

    protected function setUp()
    {
        $this->adapter = $this->createValidatorAdapter();
        $this->appRequest = new ValidAppRequest();
    }

    private function ensureValueIsValidated($field, $value, $return, $index)
    {
        $this
            ->adapter
            ->expects($this->at($index))
            ->method('validate')
            ->with($value, $this->callback(function ($constraint) {
                $this->assertInstanceOf(
                    'Symfony\Component\Validator\Constraints\NotBlank',
                    $constraint[0]
                );

                return $constraint;
            }))
            ->will($this->returnValue($return));
    }

    private function createValidatorAdapter()
    {
        return $this->createMockFor(
            'Codecontrol\FrameworkBundle\Validator\ValidatorAdapter'
        );
    }
}
