<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Filter;

use SupportYard\FrameworkBundle\Test\FilterTraitTestCase;

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
            'SupportYard\FrameworkBundle\Filter\EmailFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
