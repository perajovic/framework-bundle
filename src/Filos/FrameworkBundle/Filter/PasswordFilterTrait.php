<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait PasswordFilterTrait
{
    protected function filterPassword(Request $request, string $field): string
    {
        $filtered = $request->request->filter($field);

        return is_array($filtered) ? '' : (string) $filtered;
    }
}
