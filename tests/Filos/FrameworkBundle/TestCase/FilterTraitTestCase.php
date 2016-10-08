<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\TestCase;

use Symfony\Component\HttpFoundation\Request;

abstract class FilterTraitTestCase extends TestCase
{
    /**
     * @var Request
     */
    protected $request;

    public function setUp()
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
