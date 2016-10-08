<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Entity;

use Ramsey\Uuid\Uuid as UuidGenerator;

final class Uuid
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string|null $value
     */
    public function __construct(string $value = null)
    {
        $this->value = $value === null ? UuidGenerator::uuid4()->toString() : $value;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->value;
    }
}
