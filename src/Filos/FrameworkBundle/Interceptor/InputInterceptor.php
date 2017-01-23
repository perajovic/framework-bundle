<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Interceptor;

use Filos\FrameworkBundle\Input\RawInputInterface;
use ReflectionClass;
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

    public function __construct(ValidatorInterface $validator, RawInputInterface $rawInput)
    {
        $this->validator = $validator;
        $this->rawInput = $rawInput;
    }

    /**
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
