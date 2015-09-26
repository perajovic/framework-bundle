<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Utils;

use SupportYard\FrameworkBundle\Test\TestCase;
use SupportYard\FrameworkBundle\Utils\PasswordHelper;

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
