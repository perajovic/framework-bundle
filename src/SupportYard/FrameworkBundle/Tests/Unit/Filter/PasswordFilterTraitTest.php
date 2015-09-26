<?php

namespace SupportYard\FrameworkBundle\Tests\Unit\Filter;

use SupportYard\FrameworkBundle\Test\FilterTraitTestCase;

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
            'SupportYard\FrameworkBundle\Filter\PasswordFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
