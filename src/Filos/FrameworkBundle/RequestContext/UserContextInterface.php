<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\RequestContext;

use Filos\FrameworkBundle\Model\Uuid;

interface UserContextInterface
{
    public function getId(): Uuid;

    public function getEmail(): string;

    public function getFirstname(): ?string;

    public function getLastname(): ?string;
}
