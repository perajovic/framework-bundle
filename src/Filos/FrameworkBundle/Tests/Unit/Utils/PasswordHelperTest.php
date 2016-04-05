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
    private $passwordHelper;

    public function setUp()
    {
        parent::setUp();

        $this->passwordHelper = new PasswordHelper();
    }

    /**
     * @test
     */
    public function passwordIsHashedAndVerified()
    {
        $hash = $this->passwordHelper->hash('123abc');

        $this->assertTrue($this->passwordHelper->verify('123abc', $hash));
    }

    /**
     * @test
     * @dataProvider provideLength
     */
    public function passwordIsGenerated($length)
    {
        $this->assertSame($length, strlen($this->passwordHelper->generate($length)));
    }

    /**
     * @return array
     */
    public function provideLength(): array
    {
        return [
            [15],
            [30],
            [6],
        ];
    }
}
