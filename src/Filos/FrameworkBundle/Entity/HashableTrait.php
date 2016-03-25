<?php

namespace Filos\FrameworkBundle\Entity;

trait HashableTrait
{
    /**
     * @var string|null
     */
    private $hash;

    /**
     * @param string|null $salt
     */
    public function setHash($salt = null)
    {
        if (null === $salt) {
            $salt = uniqid(mt_rand().time(), true);
        }

        $this->hash = sha1($salt.time().$salt.rand(1000, 1000000).$salt);
    }

    /**
     * @return string|null
     */
    public function getHash()
    {
        return $this->hash;
    }
}
