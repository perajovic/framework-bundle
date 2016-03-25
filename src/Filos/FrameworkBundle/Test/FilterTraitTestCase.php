<?php

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
