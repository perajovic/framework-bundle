<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Input;

use Symfony\Component\HttpFoundation\Request;

interface RawInputInterface
{
    public function load(Request $request);
}
