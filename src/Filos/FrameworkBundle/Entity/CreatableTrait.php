<?php

namespace Filos\FrameworkBundle\Entity;

use DateTime;

trait CreatableTrait
{
    /**
     * @var int|null
     */
    private $createdBy;

    /**
     * @var DateTime|null
     */
    private $createdAt;

    /**
     * @param int|null $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return int|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param DateTime|null $createdAt
     */
    public function setCreatedAt(DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
