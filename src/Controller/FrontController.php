<?php
// src/Controller/FrontController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function frontAction()
    {
        return new Response();
    }

    public function pageNotFoundAction()
    {
        return $this->redirectToRoute('front');
    }
}
