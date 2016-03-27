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

namespace Filos\FrameworkBundle\Tests\Fixture;

use Filos\FrameworkBundle\Input\RawInputInterface;
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
