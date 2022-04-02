<?php

namespace App\Controller\commande;

use App\Controller\Controller;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class CommandeController extends Controller
{

    private UserRepository $userRepository;
    private int $userId;

    public function __construct(EntityManagerInterface $entityManager, UserInterface $user, UserRepository $userRepository)
    {
        parent::__construct($entityManager);
        $this->userId = $user->getId();
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/commande", name="app_commande")
     */

    public function Commande(): Response
    {
        $user = $this->userRepository->findOneBy(array("id" => $this->userId));
        $commandeList = $user->getCommande();

        return $this->render("commande/commande.html.twig", [
            "commandeList" => $commandeList
        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/commande/details/{id<^[1-9]{1}[0-9]*$>}", name="app_commande_details")
     */
    public function details(int $id, CommandeRepository $commandeRepository, ProductRepository $productRepository)
    {
        $user = $this->userRepository->findOneBy(array("id" => $this->userId));
        $commande = $commandeRepository->findOneBy(array("id" => $id));
        if ($commande->getIdUser() !== $user) {
            return $this->redirectToRoute("app_commande");
        }

        return $this->render("commande/commandeDetails.html.twig", [
            "commande" => $commande,
            "products" => $this->sortCommandeArray($commande, $productRepository)
        ]);
    }

    private function sortCommandeArray(Commande $commande, ProductRepository $productRepository): array
    {
        $products = array();
        foreach ($commande->getArticles() as $key => $value) {
            $products[] = [
                "product" => $productRepository->findOneBy(array("id" => $key)),
                "quantity" => $value
            ];
        }
        return $products;
    }
}