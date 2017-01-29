<?php 

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */
declare(strict_types=1);

namespace Filos\FrameworkBundle\Utils;

use RuntimeException;

/**
 * @note
 * This class is not configured in DIC.
 */
class Secret
{
    const ENCRYPT_METHOD = 'AES-256-CBC';

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $iv;

    public function __construct(string $key, string $iv)
    {
        if (!extension_loaded('openssl')) {
            throw new RuntimeException("In order to use this class you should have installed 'openssl' extension.");
        }

        $this->key = $key;
        $this->iv = $iv;
    }

    public function encrypt(string $string): string
    {
        $output = openssl_encrypt(
            $string, static::ENCRYPT_METHOD,
            $this->getGeneratedKey(),
            0,
            $this->getGeneratedIv()
        );

        return base64_encode($output);
    }

    public function decrypt(string $string): string
    {
        return openssl_decrypt(
            base64_decode($string, true),
            static::ENCRYPT_METHOD,
            $this->getGeneratedKey(),
            0,
            $this->getGeneratedIv()
        );
    }

    private function getGeneratedKey(): string
    {
        return hash('sha256', $this->key);
    }

    private function getGeneratedIv(): string
    {
        return substr(hash('sha256', $this->iv), 0, 16);
    }
}
