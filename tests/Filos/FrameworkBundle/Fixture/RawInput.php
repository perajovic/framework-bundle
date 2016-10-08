<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
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

    /**
     * {@inheritdoc}
     */
    public function load(Request $request)
    {
        $this->name = 'John Doe';
        $this->email = 'john@doe.com';
        $this->id = '123';
    }
}
