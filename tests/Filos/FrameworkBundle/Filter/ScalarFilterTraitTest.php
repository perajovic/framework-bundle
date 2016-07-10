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

namespace Tests\Filos\FrameworkBundle\Filter;

use Filos\FrameworkBundle\Filter\ScalarFilterTrait;
use Tests\Filos\FrameworkBundle\TestCase\FilterTraitTestCase;

class ScalarFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @var ScalarFilterTrait
     */
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\ScalarFilterTrait');
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
            'filterScalar',
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
            [['value'], false],
            ['value', 'value'],
            ['<div>value</div>', '<div>value</div>'],
            ['<a href="/">value</a>', '<a href="/">value</a>'],
            ['&', '&'],
            ['>', '>'],
            ['<', '<'],
            ['"', '"'],
            ["'", "'"],
            ['<script>alert("xss")</script>', '<script>alert("xss")</script>'],
        ];
    }
}
