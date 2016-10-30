<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Filos\FrameworkBundle\Model\StatusTrait;

class Status
{
    use StatusTrait;

    const STATUS_FOO = 'foo';
    const STATUS_BAR = 'bar';
}
