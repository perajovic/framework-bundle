<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Filter;

use Filos\FrameworkBundle\Filter\BooleanFilterTrait;
use Tests\Filos\FrameworkBundle\TestCase\FilterTraitTestCase;

class BooleanFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @var BooleanFilterTrait
     */
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\BooleanFilterTrait');
    }

    /**
     * @test
     *
     * @dataProvider provideValue
     */
    public function valueIsFiltered($value, $expected)
    {
        $this->setRequest('field', $value);
        $actual = $this->callNonPublicMethodWithArguments($this->filter, 'filterBoolean', [$this->request, 'field']);

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideValue(): array
    {
        return [
            [['foo'], false],
            [['foo' => 'bar'], false],
            [false, false],
            ['false', false],
            ['0', false],
            ['off', false],
            ['Off', false],
            ['some string value', false],
            ['1', true],
            ['on', true],
            ['On', true],
            [true, true],
            ['true', true],
        ];
    }
}
