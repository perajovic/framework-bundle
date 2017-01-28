<?php 

/*
 * This file is part of the Filos FrameworkBundle project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * (c) Pera Jovic <perajovic@me.com>. All rights reserved.
 */
declare(strict_types=1);

namespace Tests\Filos\FrameworkBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Filos\FrameworkBundle\TestCase\TestCase;
use stdClass;
use Tests\Filos\FrameworkBundle\Fixture\TestRepository;

class AbstractRepositoryTest extends TestCase
{
    /**
     * @var TestRepository
     */
    private $testRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var stdClass
     */
    private $entity;

    protected function setUp()
    {
        parent::setUp();

        $this->entity = new stdClass();
        $this->entityManager = $this->createMockFor(EntityManager::class);
        $this->testRepository = new TestRepository($this->entityManager);
    }

    /**
     * @test
     */
    public function entityIsCreated()
    {
        $this->entityManager->expects($this->once())->method('persist')->with($this->entity);
        $this->entityManager->expects($this->once())->method('flush');

        $this->testRepository->create($this->entity);
    }

    /**
     * @test
     */
    public function entityIsRemoved()
    {
        $this->entityManager->expects($this->once())->method('remove')->with($this->entity);
        $this->entityManager->expects($this->once())->method('flush');

        $this->testRepository->remove($this->entity);
    }

    /**
     * @test
     */
    public function entityIsPersists()
    {
        $this->entityManager->expects($this->once())->method('persist')->with($this->entity);

        $this->testRepository->persist($this->entity);
    }

    /**
     * @test
     */
    public function entityIsFlushed()
    {
        $this->entityManager->expects($this->once())->method('flush');

        $this->testRepository->flush();
    }

    /**
     * @test
     */
    public function entityRepositoryIsRetreived()
    {
        $entityRepository = $this->createMockFor(EntityRepository::class);
        $this
            ->entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('Tests\Entity\FrameworkBundle\Fixture\TestRepository')
            ->willReturn($entityRepository);

        $result = $this->callNonPublicMethodWithArguments($this->testRepository, 'getEntityRepository');

        $this->assertSame($entityRepository, $result);
    }
}
