<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model\Attribute;

use Ramsey\Uuid\Uuid as UuidGenerator;

class Uuid
{
    /**
     * @var string
     */
    private $value;

    public function __construct(?string $value = null)
    {
        $this->value = $value === null ? UuidGenerator::uuid4()->toString() : $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    public function get(): string
    {
        return $this->value;
    }
}
