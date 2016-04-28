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

namespace Filos\FrameworkBundle\Tests\Filter;

use Filos\FrameworkBundle\Test\FilterTraitTestCase;

class PasswordFilterTraitTest extends FilterTraitTestCase
{
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\PasswordFilterTrait');
    }

    /**
     * @test
     * @dataProvider provideValue
     */
    public function valueIsFiltered($value, $expected)
    {
        $this->setRequest('field', $value);
        $actual = $this->callNonPublicMethodWithArguments(
            $this->filter,
            'filterPassword',
            [$this->request, 'field']
        );

        $this->assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function provideValue(): array
    {
        return [
            [['mypass'], false],
            ['mypass', 'mypass'],
        ];
    }
}
