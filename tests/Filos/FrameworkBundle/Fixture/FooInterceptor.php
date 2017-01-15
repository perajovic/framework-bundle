<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Filos\FrameworkBundle\Interceptor\InterceptorInterface;
use Symfony\Component\HttpFoundation\Request;

class FooInterceptor implements InterceptorInterface
{
    /**
     * @var bool
     */
    public $executed = false;

    public function apply(Request $request)
    {
        $this->executed = true;
    }
}
