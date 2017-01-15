<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Utils;

use Filos\FrameworkBundle\TestCase\TestCase;
use Filos\FrameworkBundle\Utils\ConstantsToArrayResolver;
use Tests\Filos\FrameworkBundle\Fixture\ConstantToArray;

class ConstantsToArrayResolverTest extends TestCase
{
    /**
     * @var ConstantsToArrayResolver
     */
    private $resolver;

    protected function setUp()
    {
        parent::setUp();

        $this->resolver = new ConstantsToArrayResolver();
    }

    /**
     * @test
     */
    public function constantsAreResolved()
    {
        $result = $this->resolver->resolve(ConstantToArray::class, 'FOO');

        $this->assertSame(['abc', 'cde', 'xyz'], $result);
    }
}
