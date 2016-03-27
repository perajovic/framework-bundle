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

namespace Filos\FrameworkBundle\Tests\Unit\Utils;

use Filos\FrameworkBundle\Test\TestCase;
use Filos\FrameworkBundle\Utils\PasswordHelper;

class PasswordHelperTest extends TestCase
{
    /**
     * @test
     */
    public function passwordIsHashedAndVerified()
    {
        $password = '123abc';
        $hash = PasswordHelper::hash($password);

        $this->assertTrue(PasswordHelper::verify($password, $hash));
    }

    /**
     * @test
     * @dataProvider provideLength
     */
    public function passwordIsGenerated($length)
    {
        $this->assertSame($length, strlen(PasswordHelper::generate($length)));
    }

    public function provideLength()
    {
        return [
            [15],
            [30],
            [6],
        ];
    }
}
