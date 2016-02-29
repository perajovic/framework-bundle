<?php

namespace SupportYard\FrameworkBundle\Interceptor;

use ReflectionClass;
use SupportYard\FrameworkBundle\Input\RawInputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InputInterceptor implements InterceptorInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var RawInputInterface
     */
    private $rawInput;

    /**
     * @param ValidatorInterface $validator
     * @param RawInputInterface  $rawInput
     */
    public function __construct(ValidatorInterface $validator, RawInputInterface $rawInput)
    {
        $this->validator = $validator;
        $this->rawInput = $rawInput;
    }

    /**
     * @param Request $request
     *
     * @throws BadRequestHttpException
     */
    public function apply(Request $request)
    {
        $this->rawInput->load($request);

        $results = $this->validator->validate($this->rawInput);

        $errors = [];
        foreach ($results as $result) {
            $errors[$result->getPropertyPath()] = $result->getMessage();
        }

        if (!empty($errors)) {
            $sendFlatten = true;
            $params = $request->attributes->get('_route_params');
            if (isset($params['_app'])
                && array_key_exists('send_flatten', $params['_app'])
                && false === $params['_app']['send_flatten']
            ) {
                $sendFlatten = false;
            }

            throw new BadRequestHttpException(
                $sendFlatten ? implode(PHP_EOL, array_values($errors)) : json_encode($errors)
            );
        }

        $filteredInputClass = str_replace('Raw', 'Filtered', get_class($this->rawInput));

        $filteredInput = new $filteredInputClass();
        foreach ((new ReflectionClass($filteredInputClass))->getProperties() as $property) {
            $property = $property->getName();
            $filteredInput->$property = $this->rawInput->$property;
        }

        $request->attributes->set('filteredInput', $filteredInput);
    }
}
