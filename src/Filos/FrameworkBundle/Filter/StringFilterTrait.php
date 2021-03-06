<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Filter;

use Symfony\Component\HttpFoundation\Request;

trait StringFilterTrait
{
    protected function filterString(Request $request, string $field, $attribute = 'request'): string
    {
        $filtered = $request->$attribute->filter(
            $field,
            '',
            FILTER_SANITIZE_STRING,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );

        return is_string($filtered) ? (string) $filtered : '';
    }
}
