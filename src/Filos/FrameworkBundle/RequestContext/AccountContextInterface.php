<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\RequestContext;

use Filos\FrameworkBundle\Model\Uuid;

interface AccountContextInterface
{
    public function getId(): Uuid;
}
