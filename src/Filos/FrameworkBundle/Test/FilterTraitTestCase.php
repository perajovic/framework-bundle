<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Filos\FrameworkBundle\Test;

use Symfony\Component\HttpFoundation\Request;

abstract class FilterTraitTestCase extends TestCase
{
    protected $request;

    public function createRequest($method = 'POST')
    {
        return Request::create('/_filter_test', $method);
    }

    protected function setAttribute($name, $value)
    {
        $this->request->attributes->set($name, $value);
    }

    protected function setRequest($name, $value)
    {
        $this->request->request->set($name, $value);
    }
}
