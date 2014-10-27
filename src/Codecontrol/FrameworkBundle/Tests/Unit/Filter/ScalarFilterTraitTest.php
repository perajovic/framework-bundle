<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Filter;

use Codecontrol\FrameworkBundle\Test\FilterTraitTestCase;

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
        ];
    }

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait(
            'Codecontrol\FrameworkBundle\Filter\ScalarFilterTrait'
        );
        $this->request = $this->createRequest();
    }
}
