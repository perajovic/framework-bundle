<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait EmailFilterTrait
{
    protected function filterEmail(Request $request, string $field, $attribute = 'request'): string
    {
        $filtered = $request->$attribute->filter(
            $field,
            '',
            FILTER_SANITIZE_EMAIL,
            ['flags' => '']
        );

        return is_string($filtered) ? $filtered : '';
    }
}
