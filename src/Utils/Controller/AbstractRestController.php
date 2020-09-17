<?php
// src/Utils/Controller/AbstractRestController.php

namespace App\Utils\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;

abstract class AbstractRestController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;

        $this->paginator = $paginator;
    }

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
    protected function deleteEntity(&$entity): void
    {
        $this->entityManager->remove($entity);

        $this->entityManager->flush();
    }
}
