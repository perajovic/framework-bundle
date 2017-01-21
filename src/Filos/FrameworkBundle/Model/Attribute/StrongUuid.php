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

final class StrongUuid extends Uuid
{
    public function __construct(?string $value = null)
    {
        if (null === $value) {
            $value = [];
            for ($i = 0; $i < 3; ++$i) {
                $value[] = UuidGenerator::uuid4()->toString();
            }
            $value = str_replace('-', '', implode('', $value));
        }

        parent::__construct($value);
    }
}
