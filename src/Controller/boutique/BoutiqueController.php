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
     * @Route("/{_locale<%app.supported_locales%>}/boutique", name="app_boutique")
     *
     */

    public function showAll(ManagerRegistry $doctrine) : Response
    {
        $products = new ProductRepository($doctrine);
        $res=$products->getAll();
        return $this->render("boutique.html.twig", ["quantity"=>count($res)-1]);
    }
}