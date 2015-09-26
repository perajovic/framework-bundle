<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Filter;

use SupportYard\FrameworkBundle\Test\FilterTraitTestCase;

class ScalarFilterTraitTest extends FilterTraitTestCase
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
            'filterScalar',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue()
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

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'SupportYard\FrameworkBundle\Filter\ScalarFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
