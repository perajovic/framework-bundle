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

        $this->assertFalse($appRequest->isValid());
        $this->assertEquals(
            ['foo' => 'foo-error', 'baz' => 'baz-error'],
            $appRequest->getErrors()
        );
        $this->assertSame("foo-error\nbaz-error", $appRequest->getFlattenErrors());
    }

    /**
     * @test
     */
    public function validationPassed()
    {
        $appRequest = new ValidAppRequest($this->adapter);

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
