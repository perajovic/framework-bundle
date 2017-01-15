<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Filter;

use Filos\FrameworkBundle\Filter\StringFilterTrait;
use Tests\Filos\FrameworkBundle\TestCase\FilterTraitTestCase;

class StringFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @var StringFilterTrait
     */
    private $filter;

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\StringFilterTrait');
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
            'filterString',
            [$this->request, 'field']
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue(): array
    {
        return [
            [['some string'], ''],
            ['', ''],
            [null, ''],
            ['some string', 'some string'],
            ['some string with "', 'some string with "'],
            ['some string with \'', 'some string with \''],
            ['<script>some string</script>', 'some string'],
            ['<a href="#">some string</a>', 'some string'],
        ];
    }
}
