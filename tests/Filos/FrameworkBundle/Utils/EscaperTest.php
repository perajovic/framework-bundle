<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Utils;

use Filos\FrameworkBundle\Utils\Escaper;
use stdClass;
use Filos\FrameworkBundle\TestCase\TestCase;

class EscaperTest extends TestCase
{
    /**
     * @var Escaper
     */
    private $escaper;

    public function setUp()
    {
        parent::setUp();

        $this->escaper = new Escaper();
    }

    /**
     * @test
     *
     * @param mixed $expected
     * @param mixed $actual
     * @dataProvider provideScalarTypes
     */
    public function scalarTypesExceptStringAreNotEscaped($expected, $actual)
    {
        $this->assertSame($expected, $this->escaper->escape($actual));
    }

    /**
     * @return array
     */
    public function provideScalarTypes(): array
    {
        return [
            [4, 4],
            [4.32, 4.32],
            [null, null],
            [false, false],
            [true, true],
        ];
    }

    /**
     * @test
     *
     * @param string $expected
     * @param string $actual
     * @dataProvider provideNotModifiedEscapedChars
     */
    public function notModifiedEscapedChars(string $expected, string $actual)
    {
        $this->assertSame($expected, $this->escaper->escape($actual));
    }

    /**
     * @return array
     */
    public function provideNotModifiedEscapedChars(): array
    {
        return [
            ['zxcvbnmasdfghjklqwertyuiop', 'zxcvbnmasdfghjklqwertyuiop'],
            ['ZXCVBNMASDFGHJKLQWERTYUIOneplatform', 'ZXCVBNMASDFGHJKLQWERTYUIOneplatform'],
            ['`,./;\\[]1234567890-=', '`,./;\\[]1234567890-='],
            ['~?:|!@#$%^*()_+', '~?:|!@#$%^*()_+'],
            ['ŠšĐđČčĆćŽž', 'ŠšĐđČčĆćŽž'],
            ['ШшЂђЧчЋћЖжЉљЊњ', 'ШшЂђЧчЋћЖжЉљЊњ'],
        ];
    }

    /**
     * @test
     */
    public function modifiedEscapedChars()
    {
        // in browser, special chars in simple text output and in form fields
        // (as value attribute) are displayed as '&<>"

        $this->assertSame('&#039;&amp;&lt;&gt;&quot;', $this->escaper->escape('\'&<>"'));
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
            (array) $this->escaper->escape($obj)
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

        $data = ['foo<' => ['foo\''], 'bar' => $obj, 'baz&', 'zaz' => null, 'vaz' => '11"'];

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
           $this->escaper->escape($data)
        );
    }
}
