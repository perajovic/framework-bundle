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

class StringFilterTraitTest extends FilterTraitTestCase
{
    private $request;
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->request = $this->createRequest();
        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\StringFilterTrait');
    }

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
            'filterString',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue(): array
    {
        return [
            [['some string'], false],
            ['some string', 'some string'],
            ['some string with "', 'some string with "'],
            ['some string with \'', 'some string with \''],
            ['<script>some string</script>', 'some string'],
            ['<a href="#">some string</a>', 'some string'],
        ];
    }
}
