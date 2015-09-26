<?php

namespace SupportYard\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait BooleanFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     * @param string  $attribute
     *
     * @return bool
     */
    protected function filterBoolean(
        Request $request,
        $field,
        $attribute = 'request'
    ) {
        $filtered = $request->{$attribute}->filter(
            $field,
            false,
            false,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        return null === $filtered ? false : (boolean) $filtered;
    }
}
