<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Filter;

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
    protected function filterBoolean(Request $request, string $field, $attribute = 'request'): bool
    {
        $filtered = $request->$attribute->filter(
            $field,
            false,
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        );

        return null === $filtered ? false : (bool) $filtered;
    }
}
