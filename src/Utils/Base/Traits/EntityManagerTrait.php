<?php
// src/Utils/Base/Trait/EntityManagerTrait.php

namespace App\Utils\Base\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

trait EntityManagerTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param string $className
     * @param array $criteria
     * @return mixed
     */
    protected function getEntity(string $className, array $criteria)
    {
        $repository = $this->entityManager->getRepository($className);

        return $repository->findOneBy($criteria);
    }

    /**
     * @param string $entity
     * @param string $alias
     * @return QueryBuilder
     */
    protected function getQueryBuilder(string $entity, string $alias): QueryBuilder
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select($alias)
            ->from($entity, $alias);
    }

    /**
     * @param $entity
     */
    protected function persistEntity(&$entity): void
    {
        $this->entityManager->persist($entity);

        $this->entityManager->flush();
    }

    /**
     * @param $entity
     */
    protected function removeEntity(&$entity): void
    {
        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }
}
