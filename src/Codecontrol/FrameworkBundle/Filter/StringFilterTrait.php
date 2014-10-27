<?php

namespace Codecontrol\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait StringFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     * @param string  $attribute
     *
     * @return string
     */
    protected function filterString(Request $request, $field, $attribute = 'request')
    {
        return $request->{$attribute}->filter(
            $field,
            null,
            false,
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );
    }
}
