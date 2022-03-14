<?php

namespace App\Controller\boutique;

use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueControlleur extends AbstractController
{
    /**
     * @Route("/boutique", name="app_boutique")
     */
    public function boutique(): Response
    {
        return $this->render('boutique/boutique.html.twig', [
            'message' => 'test'
        ]);
    }


}
