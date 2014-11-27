<?php

namespace Codecontrol\FrameworkBundle\Tests\Fixtures;

use Codecontrol\FrameworkBundle\Request\AppRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class ValidAppRequest extends AppRequest
{
    private $foo = 'foo-val';
    private $bar = 'bar-val';
    private $baz = 'baz-val';
    private $zaz = [1, '', 'my_value', null];
    private $vaz = [
        ['custom_key' => ''],
        ['custom_key' => 12],
        ['custom_key' => null],
    ];

    public function getFoo()
    {
        return $this->foo;
    }

    public function getBar()
    {
        return $this->bar;
    }

    public function getBaz()
    {
        return $this->baz;
    }

    public function getZaz()
    {
        return $this->zaz;
    }

    public function getVaz()
    {
        return $this->vaz;
    }

    public function populateFields(Request $request)
    {
    }

    protected function validateFields()
    {
        $this->validate('foo', [new NotBlank()]);
        $this->validate('bar', [new NotBlank()]);
        $this->validate('baz', [new NotBlank()]);
        $this->validate('zaz', [new NotBlank()], true);
        $this->validate('vaz', [new NotBlank()], true, 'custom_key');
    }
}
