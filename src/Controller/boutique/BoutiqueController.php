<?php

namespace App\Controller\boutique;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="app_boutique")
     *
     */

    public function showAll(ManagerRegistry $doctrine) : Response
    {
        $products = new ProductRepository($doctrine);
        $res=$products->getAll();
        return $this->render("boutique.html.twig", ["quantity"=>count($res)-1]);
    }
}