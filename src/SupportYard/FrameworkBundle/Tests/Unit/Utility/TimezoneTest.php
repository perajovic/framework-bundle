<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Utility;

use SupportYard\FrameworkBundle\Test\TestCase;
use SupportYard\FrameworkBundle\Utility\Timezone;

class TimezoneTest extends TestCase
{
    /**
     * @test
     */
    public function displayListIsRetrieved()
    {
        $this->assertNotEmpty(Timezone::getDisplayList());
    }

    /**
     * @test
     */
    public function ifTimezoneIdIsInvalidUtcIsReturned()
    {
        $id = 'foo_bar';

        $this->assertSame('UTC', Timezone::getId($id));
    }

    /**
     * @test
     */
    public function timezoneIsReturned()
    {
        $id = 'belgrade';

        $this->assertSame('Europe/Belgrade', Timezone::getId($id));
    }
}
