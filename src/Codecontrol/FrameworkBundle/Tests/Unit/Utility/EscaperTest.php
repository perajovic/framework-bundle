<?php

namespace Codecontrol\FrameworkBundle\Tests\Unit\Utility;

use Codecontrol\FrameworkBundle\Test\TestCase;
use Codecontrol\FrameworkBundle\Utility\Escaper;
use stdClass;

class EscaperTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideScalarTypes
     */
    public function scalarTypesExceptStringAreNotEscaped($expected, $actual)
    {
        $this->assertSame($expected, Escaper::escape($actual));
    }

    /**
     * @test
     * @dataProvider provideNotModifiedEscapedChars
     */
    public function notModifiedEscapedChars($expected, $actual)
    {
        $this->assertSame($expected, Escaper::escape($actual));
    }

    /**
     * @test
     */
    public function modifiedEscapedChars()
    {
        // in browser, special chars in simple text output and in form fields
        // (as value attribute) are displayed as '&<>"

        $this->assertSame('&#039;&amp;&lt;&gt;&quot;', Escaper::escape('\'&<>"'));
    }

    /**
     * @test
     */
    public function objectIsEscaped()
    {
        $obj = new stdClass();
        $obj->foo = '_foo<';
        $obj->bar = '_bar>';

        $this->assertSame(
            ['foo' => '_foo&lt;', 'bar' => '_bar&gt;'],
            (array) Escaper::escape($obj)
        );
    }

    /**
     * @test
     */
    public function arrayIsEscaped()
    {
        $obj = new stdClass();
        $obj->foo = '_foo<';
        $obj->bar = '_bar>';

        $data = [
            'foo<' => ['foo\''],
            'bar' => $obj,
            'baz&',
            'zaz' => null,
            'vaz' => '11"',
        ];

        $this->assertSame(
            [
                'foo<' => ['foo&#039;'],
                'bar' => [
                    'foo' => '_foo&lt;',
                    'bar' => '_bar&gt;',
                ],
                'baz&amp;',
                'zaz' => null,
                'vaz' => '11&quot;',
            ],
           Escaper::escape($data)
        );
    }

    public function provideScalarTypes()
    {
        return [
            [4, 4],
            [4.32, 4.32],
            [null, null],
            [false, false],
            [true, true],
        ];
    }

    public function provideNotModifiedEscapedChars()
    {
        return [
            ['zxcvbnmasdfghjklqwertyuiop', 'zxcvbnmasdfghjklqwertyuiop'],
            [
                'ZXCVBNMASDFGHJKLQWERTYUIOneplatform',
                'ZXCVBNMASDFGHJKLQWERTYUIOneplatform',
            ],
            ['`,./;\\[]1234567890-=', '`,./;\\[]1234567890-='],
            ['~?:|!@#$%^*()_+', '~?:|!@#$%^*()_+'],
            ['ŠšĐđČčĆćŽž', 'ŠšĐđČčĆćŽž'],
            ['ШшЂђЧчЋћЖжЉљЊњ', 'ШшЂђЧчЋћЖжЉљЊњ'],
        ];
    }
}
