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

use Filos\FrameworkBundle\Model\Uuid;
use Filos\FrameworkBundle\RequestContext\UserContextInterface;

class UserContext implements UserContextInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId(): Uuid
    {
        return new Uuid('123-abc-efg');
    }

    public function getEmail(): string
    {
        return 'john@doe.com';
    }

    public function getFirstname(): ?string
    {
        return 'John';
    }

    public function getLastname(): ?string
    {
        return 'Doe';
    }
}
