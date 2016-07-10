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

namespace Tests\Filos\FrameworkBundle\Interceptor;

use Filos\FrameworkBundle\Interceptor\InputInterceptor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\Filos\FrameworkBundle\Fixture\RawInput;
use Tests\Filos\FrameworkBundle\TestCase\TestCase;

class InputInterceptorTest extends TestCase
{
    /**
     * @var ConstraintViolationInterface
     */
    private $constraint;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var RawInput
     */
    private $rawInput;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var InputInterceptor
     */
    private $interceptor;

    public function setUp()
    {
        $this->constraint = $this->createConstraintViolation();
        $this->validator = $this->createValidator();
        $this->rawInput = new RawInput();
        $this->request = Request::create('/_interceptor_test', 'POST');
        $this->interceptor = new InputInterceptor($this->validator, $this->rawInput);
    }

    /**
     * @test
     */
    public function filteredInputIsSettledAsAttribute()
    {
        $results = [];

        $this->ensureValidation($results);

        $this->interceptor->apply($this->request);

        $filteredInput = $this->request->attributes->get('filtered_input');

        $this->assertSame('John Doe', $filteredInput->name);
        $this->assertSame('john@doe.com', $filteredInput->email);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage error text
     */
    public function exceptionIsThrownWithFlattenErrors()
    {
        $results = [$this->constraint];
        $message = 'error text';
        $propertyPath = 'some_field';

        $this->ensureValidation($results);
        $this->ensureConstraint($propertyPath, $message);

        $this->interceptor->apply($this->request);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage {"some_field":"error text"}
     */
    public function exceptionIsThrownWithJsonEncodedErrors()
    {
        $results = [$this->constraint];
        $message = 'error text';
        $propertyPath = 'some_field';

        $this->request->attributes->set('_route_params', [
            '_app' => ['send_flatten' => false],
        ]);
        $this->ensureValidation($results);
        $this->ensureConstraint($propertyPath, $message);

        $this->interceptor->apply($this->request);
    }

    /**
     * @param string $propertyPath
     * @param string $message
     */
    private function ensureConstraint(string $propertyPath, string $message)
    {
        $this
            ->constraint
            ->expects($this->once())
            ->method('getMessage')
            ->will($this->returnValue($message));
        $this
            ->constraint
            ->expects($this->once())
            ->method('getPropertyPath')
            ->will($this->returnValue($propertyPath));
    }

    /**
     * @param array $results
     */
    private function ensureValidation(array $results)
    {
        $this
            ->validator
            ->expects($this->once())
            ->method('validate')
            ->with($this->rawInput)
            ->will($this->returnValue($results));
    }

    private function createValidator()
    {
        return $this->createMockFor(
            'Symfony\Component\Validator\Validator\ValidatorInterface'
        );
    }

    private function createConstraintViolation()
    {
        return $this->createMockFor(
            'Symfony\Component\Validator\ConstraintViolationInterface'
        );
    }
}
