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

class EmailFilterTraitTest extends FilterTraitTestCase
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
            'filterEmail',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue()
    {
        return [
            [['john@doe'], false],
            ['john@doe', 'john@doe'],
            ['john@doe.com', 'john@doe.com'],
            ['(john@doe.com)', 'john@doe.com'],
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'Filos\FrameworkBundle\Filter\EmailFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
