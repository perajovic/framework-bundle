<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Utils;

use ReflectionClass;

class ConstantsToArrayResolver
{
    public function resolve(string $class, string $pattern): array
    {
        $options = [];

        $constants = (new ReflectionClass($class))->getConstants();

        foreach ($constants as $name => $value) {
            if (0 === strpos($name, $pattern.'_')) {
                $options[] = constant($class.'::'.$name);
            }
        }

        return $options;
    }
}
