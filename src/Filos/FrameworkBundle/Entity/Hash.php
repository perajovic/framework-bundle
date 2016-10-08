<?php

/*
 * This file is part of the Filos framework.
 *
 * (c) Pera Jovic <perajovic@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Entity;

class Hash
{
    /**
     * @var string|null
     */
    private $hash;

    /**
     * @param string|null $salt
     */
    public function __construct(string $salt = null)
    {
        if (null === $salt) {
            $salt = uniqid(mt_rand().time(), true);
        }

        $this->hash = sha1($salt.time().$salt.rand(1000, 10000000).$salt);
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->hash;
    }
}
