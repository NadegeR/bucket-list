<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function home(): Response
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("aboutUs", name="aboutUs")
     */
    public function aboutUs():Response{
        return $this->render('main/aboutUs.html.twig');
    }
}