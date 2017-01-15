<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Utils;

final class Escaper
{
    /**
     * @param mixed $var
     *
     * @return mixed
     */
    public function escape($var)
    {
        $escaper = function ($value) {
            return is_string($value)
                ? htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false)
                : $value;
        };

        if (is_null($var) || is_scalar($var)) {
            return $escaper($var);
        }

        if (is_object($var)) {
            return $this->escape((array) $var);
        }

        foreach ($var as $key => $value) {
            if (is_array($value)) {
                $var[$key] = $this->escape($value);
            } elseif (is_object($value)) {
                $var[$key] = $this->escape((array) $value);
            } else {
                $var[$key] = $escaper($value);
            }
        }

        return $var;
    }
}
