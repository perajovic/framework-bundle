<?php

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */

declare(strict_types=1);

namespace Filos\FrameworkBundle\Doctrine\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Filos\FrameworkBundle\Entity\Uuid;

class UuidType extends Type
{
    const UUID = 'uuid';

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return null !== $value ? new Uuid($value) : null;
    }

    /**
     * {@inheritdoc}
     * If the value of the field is NULL the method convertToDatabaseValue() is not called.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /* @var Uuid $value */
        return $value->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::UUID;
    }
}