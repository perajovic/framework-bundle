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

use Filos\FrameworkBundle\Filter\PasswordFilterTrait;
use Tests\Filos\FrameworkBundle\TestCase\FilterTraitTestCase;

class PasswordFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @var PasswordFilterTrait
     */
    private $filter;

    protected function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\PasswordFilterTrait');
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
            'filterPassword',
            [$this->request, 'field']
        );

        $this->assertSame($expected, $actual);
    }

    public function provideValue(): array
    {
        return [
            [['mypass'], ''],
            [null, ''],
            ['', ''],
            ['mypass', 'mypass'],
        ];
    }
}
