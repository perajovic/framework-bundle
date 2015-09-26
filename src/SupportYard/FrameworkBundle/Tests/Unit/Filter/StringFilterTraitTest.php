<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Filter;

use SupportYard\FrameworkBundle\Test\FilterTraitTestCase;

class StringFilterTraitTest extends FilterTraitTestCase
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
            'filterString',
            [$this->request, $field]
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue()
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

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'SupportYard\FrameworkBundle\Filter\StringFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
