<?php
// src/Utils/Base/AbstractRestController.php

namespace App\Utils\Base;

use App\Utils\Base\Traits\EntityManagerTrait;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View as BaseView;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractRestController extends AbstractFOSRestController
{
    use EntityManagerTrait;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * AbstractRestController constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManager;

        $this->paginator = $paginator;
    }

    /**
     * @param $response
     * @return Response
     */
    protected function handleResponse($response): Response
    {
        $view = new BaseView();
        $view->setData($response);

        return $this->handleView($view);
    }
}
