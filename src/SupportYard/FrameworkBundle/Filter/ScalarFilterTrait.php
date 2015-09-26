<?php

namespace SupportYard\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait ScalarFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     * @param string  $attribute
     *
     * @return string|null
     */
    protected function filterScalar(Request $request, $field, $attribute = 'request')
    {
        $filtered = $request->{$attribute}->filter($field);

        return is_array($filtered) ? false : $filtered;
    }
}
