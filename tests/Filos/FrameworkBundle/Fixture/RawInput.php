<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Fixture;

use Filos\FrameworkBundle\Input\RawInputInterface;
use Symfony\Component\HttpFoundation\Request;

class RawInput implements RawInputInterface
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    private $id;

    public function load(Request $request)
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->id = '123';
    }
}
