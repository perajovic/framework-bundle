<?php

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait PasswordFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     *
     * @return string|null
     */
    protected function filterPassword(Request $request, $field)
    {
        $filtered = $request->request->filter($field);

        return is_array($filtered) ? false : $filtered;
    }
}
