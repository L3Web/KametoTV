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

    /**
     * @Route("/{_locale<%app.supported_locales%>}/boutique/clothes", name="app_boutiqueC")
     *
     */

    public function boutiqueC(ProductRepository $productRepository): Response
    {
        $res = $productRepository->getClothesProduct();
        return $this->render('boutique/boutique.html.twig', [
            'ProductAll' => $res,

        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/boutique/others", name="app_boutiqueO")
     *
     */

    public function boutiqueO(ProductRepository $productRepository): Response
    {
        $res = $productRepository->getOthersProduct();
        return $this->render('boutique/boutique.html.twig', [
            'ProductAll' => $res,

        ]);
    }
}