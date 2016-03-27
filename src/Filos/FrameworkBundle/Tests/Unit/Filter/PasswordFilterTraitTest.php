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

class PasswordFilterTraitTest extends FilterTraitTestCase
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
            'filterPassword',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue()
    {
        return [
            [['mypass'], false],
            ['mypass', 'mypass'],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Filter\PasswordFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
