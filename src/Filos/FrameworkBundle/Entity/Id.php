<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Entity;

final class Id
{
    /**
     * @var int|null
     */
    private $value;

    /**
     * @param int|null $value
     */
    public function __construct(int $value = null)
    {
        $this->value = $value;
    }

    /**
     * @return int|null
     */
    public function get(): ?int
    {
        return $this->value;
    }
}
