<?php

namespace Filos\FrameworkBundle\Entity;

use DateTime;

trait UpdatableTrait
{
    /**
     * @var int|null
     */
    private $updatedBy;

    /**
     * @var DateTime|null
     */
    private $updatedAt;

    /**
     * @param int|null $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return int|null
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
