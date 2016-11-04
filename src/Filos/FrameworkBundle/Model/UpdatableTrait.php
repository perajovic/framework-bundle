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

    /**
     * @param ManagedBy $updatedBy
     */
    public function setUpdatedBy(ManagedBy $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return ManagedBy|null
     */
    public function getUpdatedBy(): ?ManagedBy
    {
        return $this->updatedBy;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}
