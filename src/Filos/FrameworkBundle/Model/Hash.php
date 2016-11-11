<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

final class Hash
{
    /**
     * @var string
     */
    private $value;

    public function __construct(?string $salt = null)
    {
        if (null === $salt) {
            $salt = uniqid((string) mt_rand(), true);
        }

        $this->value = hash('sha256', $salt.microtime().$salt);
    }

    public function get(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
