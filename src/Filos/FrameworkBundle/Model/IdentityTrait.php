<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

trait IdentityTrait
{
    /**
     * @var Uuid
     */
    private $id;

    public function getId(): Uuid
    {
        return $this->id;
    }
}
