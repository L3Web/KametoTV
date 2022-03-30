<?php

namespace App\Controller\boutique;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/boutique", name="app_boutique")
     *
     */

    public function boutique(ProductRepository $productRepository): Response
    {
        $res = $productRepository->getAllProduct();
        return $this->render('boutique/boutique.html.twig', [
            'ProductAll' => $res,

        ]);
    }
}