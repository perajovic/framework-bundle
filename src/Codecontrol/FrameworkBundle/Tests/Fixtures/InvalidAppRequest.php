<?php

namespace Codecontrol\FrameworkBundle\Tests\Fixtures;

use Codecontrol\FrameworkBundle\Request\AppRequest;
use Symfony\Component\HttpFoundation\Request;

class InvalidAppRequest extends AppRequest
{
    public function populateFields(Request $request)
    {
    }

    protected function validateFields()
    {
        $this->validate('foo', []);
    }
}
