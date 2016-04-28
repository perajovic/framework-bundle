<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Tests\Filos\FrameworkBundle\Entity;

use Tests\Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Entity\Identity;

class IdentityTest extends TestCase
{
    /**
     * @test
     */
    public function idIsSettledAndRetrieved()
    {
        $identity = new Identity(123);

        $this->assertSame(123, $identity->get());
    }
}
