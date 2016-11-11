<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Model;

use DateTime;

trait UpdatableTrait
{
    /**
     * @var ManagedBy|null
     */
    private $updatedBy;

    /**
     * @var DateTime|null
     */
    private $updatedAt;

    public function setUpdatedBy(ManagedBy $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    public function setUpdatedAt(DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedBy(): ?ManagedBy
    {
        return $this->updatedBy;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}
