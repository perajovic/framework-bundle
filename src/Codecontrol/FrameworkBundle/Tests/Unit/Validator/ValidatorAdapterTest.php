<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Validator;

use Codecontrol\FrameworkBundle\Test\TestCase;
use Codecontrol\FrameworkBundle\Validator\ValidatorAdapter;

class ValidatorAdapterTest extends TestCase
{
    /**
     * @test
     */
    public function ifValidationPassEmptyArrayIsReturned()
    {
        $actual = $this->validatorAdapter->validate('foo');

        $this->assertEmpty($actual);
    }

    /**
     * @test
     */
    public function ifValidationFailsErrorArrayIsReturned()
    {
        $value1 = 'foo';
        $error1 = 'Foo message';
        $constraint1 = $this->createConstraint();
        $value2 = 'bar';
        $error2 = 'Bar message';
        $constraint2 = $this->createConstraint();
        $value = 'my value';
        $group = 'my_group';

        $this->ensureValidationErrors(
            $value1,
            $error1,
            $constraint1,
            $value2,
            $error2,
            $constraint2,
            $value,
            $group
        );

        $actual = $this->validatorAdapter->validate($value, $group, true, true);

        $this->assertEquals([$value1 => $error1, $value2 => $error2], $actual);
    }

    /**
     * @test
     */
    public function singleValidationValueIsFailed()
    {
        $value = 'foo';
        $error = 'Foo message';

        $this->ensureValidationIsFailed($value, $error);

        $actual = $this->validatorAdapter->validateValue(
            $value,
            [$this->constraint]
        );

        $this->assertEquals($error, $actual);
    }

    /**
     * @test
     */
    public function singleValidationValueIsPassed()
    {
        $value = 'foo';

        $this->ensureValidationIsPassed($value);

        $actual = $this->validatorAdapter->validateValue(
            $value,
            [$this->constraint]
        );

        $this->assertNull($actual);
    }

    protected function setUp()
    {
        $this->constraint = $this->createConstraint();
        $this->validator = $this->createValidator();
        $this->validatorAdapter = new ValidatorAdapter($this->validator);
    }

    private function ensureValidationIsFailed($value, $error)
    {
        $this
            ->validator
            ->expects($this->once())
            ->method('validateValue')
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
            ->method('validateValue')
            ->with($value, [$this->constraint])
            ->will($this->returnValue([]));
    }

    private function ensureValidationErrors(
        $value1,
        $error1,
        $constraint1,
        $value2,
        $error2,
        $constraint2,
        $value,
        $group
    ) {
        $mockConstraintReturnValue = function ($constraint, $propertyPath, $message) {
            $constraint
                ->expects($this->once())
                ->method('getPropertyPath')
                ->will($this->returnValue($propertyPath));
            $constraint
                ->expects($this->once())
                ->method('getMessage')
                ->will($this->returnValue($message));

            return $constraint;
        };

        $this
            ->validator
            ->expects($this->once())
            ->method('validate')
            ->with($value, $group, true, true)
            ->will($this->returnValue([
                $mockConstraintReturnValue(
                    $constraint1,
                    $value1,
                    $error1
                ),
                $mockConstraintReturnValue(
                    $constraint2,
                    $value2,
                    $error2
                ),
            ]));
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
            'Symfony\Component\Validator\ValidatorInterface'
        );
    }
}
