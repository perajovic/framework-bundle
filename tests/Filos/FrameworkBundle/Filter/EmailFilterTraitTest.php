<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Filter;

use Filos\FrameworkBundle\Filter\EmailFilterTrait;
use Tests\Filos\FrameworkBundle\TestCase\FilterTraitTestCase;

class EmailFilterTraitTest extends FilterTraitTestCase
{
    /**
     * @var EmailFilterTrait
     */
    private $filter;

    public function setUp()
    {
        parent::setUp();

        $this->filter = $this->getObjectForTrait('Filos\FrameworkBundle\Filter\EmailFilterTrait');
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
            'filterEmail',
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
            [['john@doe'], ''],
            ['', ''],
            [null, ''],
            ['john@doe', 'john@doe'],
            ['john@doe.com', 'john@doe.com'],
            ['(john@doe.com)', 'john@doe.com'],
        ];
    }
}
