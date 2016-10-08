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

namespace Filos\FrameworkBundle\Input;

use Symfony\Component\HttpFoundation\Request;

interface RawInputInterface
{
    /**
     * @param Request $request
     */
    public function load(Request $request);
}
