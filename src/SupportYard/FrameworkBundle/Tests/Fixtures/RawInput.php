<?php

namespace SupportYard\FrameworkBundle\Tests\Fixtures;

use SupportYard\FrameworkBundle\Input\RawInputInterface;
use Symfony\Component\HttpFoundation\Request;

class RawInput implements RawInputInterface
{
    public $name;
    public $email;
    private $id;

    public function load(Request $request)
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->id = '123';
    }
}
