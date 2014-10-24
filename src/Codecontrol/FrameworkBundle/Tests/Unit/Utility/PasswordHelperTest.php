<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Utility;

use Codecontrol\FrameworkBundle\Test\TestCase;
use Codecontrol\FrameworkBundle\Utility\PasswordHelper;

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
