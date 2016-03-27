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
