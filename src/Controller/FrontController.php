<?php
// src/Controller/FrontController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function frontAction()
    {
        return $this->redirectToRoute('app.swagger_ui');
    }

    public function pageNotFoundAction()
    {
        return $this->redirectToRoute('front');
    }
}
