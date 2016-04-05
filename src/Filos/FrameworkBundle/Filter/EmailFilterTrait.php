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

trait EmailFilterTrait
{
    /**
     * @param Request $request
     * @param string  $field
     * @param string  $attribute
     *
     * @return string
     */
    protected function filterEmail(Request $request, string $field, $attribute = 'request')
    {
        return $request->$attribute->filter(
            $field,
            null,
            FILTER_SANITIZE_EMAIL,
            ['flags' => '']
        );
    }
}
