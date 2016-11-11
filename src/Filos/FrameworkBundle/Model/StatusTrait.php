<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

use Filos\FrameworkBundle\Utils\ConstantsToArrayResolver;

trait StatusTrait
{
    /**
     * @var string
     */
    private $status;

    public function getStatus(): string
    {
        return $this->status;
    }

    public static function getStatuses(): array
    {
        return (new ConstantsToArrayResolver())->resolve(static::class, 'STATUS');
    }
}
