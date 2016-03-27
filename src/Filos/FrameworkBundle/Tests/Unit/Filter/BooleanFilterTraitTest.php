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

namespace Filos\FrameworkBundle\Tests\Unit\Filter;

use Filos\FrameworkBundle\Test\FilterTraitTestCase;

class BooleanFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @test
     * @dataProvider provideValue
     */
    public function valueIsFiltered($value, $expected)
    {
        $field = 'field';

        $this->setRequest($field, $value);
        $actual = $this->callNonPublicMethodWithArguments(
            $this->filter,
            'filterBoolean',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue()
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

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Filter\BooleanFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
