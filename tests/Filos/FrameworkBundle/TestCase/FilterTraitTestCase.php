<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\TestCase;

use Filos\FrameworkBundle\TestCase\TestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class FilterTraitTestCase extends TestCase
{
    /**
     * @var Request
     */
    protected $request;

    protected function setUp()
    {
        parent::setUp();

        $this->request = Request::create('/_filter_test', 'POST');
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    protected function setRequest(string $name, $value)
    {
        $this->request->request->set($name, $value);
    }
}
