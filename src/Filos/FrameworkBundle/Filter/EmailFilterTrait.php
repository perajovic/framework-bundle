<?php

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait EmailFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     * @param string  $attribute
     *
     * @return string
     */
    protected function filterEmail(Request $request, $field, $attribute = 'request')
    {
        return $request->{$attribute}->filter(
            $field,
            null,
            FILTER_SANITIZE_EMAIL,
            ['flags' => '']
        );
    }
}