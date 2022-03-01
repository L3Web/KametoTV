<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="app_base_home")
     */
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'message' => 'home'
        ]);
    }
}