<?php

namespace Filos\FrameworkBundle\Entity;

trait IdentityTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }
}