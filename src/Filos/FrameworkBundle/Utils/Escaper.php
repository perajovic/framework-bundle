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

namespace Filos\FrameworkBundle\Utils;

class Escaper
{
    /**
     * @param mixed $var
     *
     * @return mixed
     */
    public static function escape($var)
    {
        $escaper = function ($value) {
            return is_string($value)
                ? htmlspecialchars(
                    $value,
                    ENT_QUOTES | ENT_SUBSTITUTE,
                    'UTF-8',
                    false
                )
                : $value;
        };

        if (is_null($var) || is_scalar($var)) {
            return $escaper($var);
        }

        if (is_object($var)) {
            return static::escape((array) $var);
        }

        foreach ($var as $key => $value) {
            if (is_array($value)) {
                $var[$key] = static::escape($value);
            } elseif (is_object($value)) {
                $var[$key] = static::escape((array) $value);
            } else {
                $var[$key] = $escaper($value);
            }
        }

        return $var;
    }
}
