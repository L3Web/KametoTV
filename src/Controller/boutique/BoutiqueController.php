<?php

namespace App\Controller\boutique;

use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="app_boutique")
     */
    public function boutique(ManagerRegistry $doctrine): Response
    {

        $ProductRepository = new ProductRepository($doctrine);
        $res = $ProductRepository->getAllProduct();
        return $this->render('boutique/boutique.html.twig', [
            'ProductAll' => $res,

        ]);
    }
}
