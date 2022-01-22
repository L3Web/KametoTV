<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function home() : Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/login")
     */
    public function login() : Response
    {
        return $this->render('login.html.twig');
    }
}