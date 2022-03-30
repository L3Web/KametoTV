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
    public function lang() : Response
    {
        return $this->redirectToRoute("app_base_home", ["_locale"=>"en"]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}", name="app_base_home")
     */
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'message' => 'Home'
        ]);
    }
}