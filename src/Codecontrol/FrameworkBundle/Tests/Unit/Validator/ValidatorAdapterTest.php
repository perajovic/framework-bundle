<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Validator;

use Codecontrol\FrameworkBundle\Test\TestCase;
use Codecontrol\FrameworkBundle\Validator\ValidatorAdapter;

class ValidatorAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function valueIsNotValid()
    {
        $value = 'foo';
        $error = 'Foo message';

        $this->ensureValidationIsFailed($value, $error);

        $actual = $this->adapter->validate($value, [$this->constraint]);

        $this->assertEquals($error, $actual);
    }

    /**
     * @test
     */
    public function valueIsValid()
    {
        $value = 'foo';

        $this->ensureValidationIsPassed($value);

        $actual = $this->adapter->validate($value, [$this->constraint]);

        $this->assertNull($actual);
    }

    protected function setUp()
    {
        $this->constraint = $this->createConstraint();
        $this->validator = $this->createValidator();
        $this->adapter = new ValidatorAdapter($this->validator);
    }

    private function ensureValidationIsFailed($value, $error)
    {
        $this
            ->validator
            ->expects($this->once())
            ->method('validate')
            ->with($value, [$this->constraint])
            ->will($this->returnValue([$this->constraint]));
        $this
            ->constraint
            ->expects($this->once())
            ->method('getMessage')
            ->will($this->returnValue($error));
    }

    private function ensureValidationIsPassed($value)
    {
        $this
            ->validator
            ->expects($this->once())
            ->method('validate')
            ->with($value, [$this->constraint])
            ->will($this->returnValue([]));
    }

    private function createConstraint()
    {
        return $this->createMockFor(
            'Symfony\Component\Validator\ConstraintViolationInterface'
        );
    }

    private function createValidator()
    {
        return $this->createMockFor(
            'Symfony\Component\Validator\Validator\ValidatorInterface'
        );
    }
}
