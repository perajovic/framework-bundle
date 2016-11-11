<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

use Ramsey\Uuid\Uuid as UuidGenerator;

final class Uuid
{
    /**
     * @var string
     */
    private $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value === null ? UuidGenerator::uuid4()->toString() : $value;
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
