<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait PasswordFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     *
     * @return string
     */
    protected function filterPassword(Request $request, string $field): string
    {
        $filtered = $request->request->filter($field);

        return is_array($filtered) ? '' : (string) $filtered;
    }
}
