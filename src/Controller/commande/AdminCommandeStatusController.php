<?php

namespace App\Controller\commande;

use App\Controller\Controller;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommandeStatusController extends Controller
{
    private CommandeRepository $commandeRepository;

    #[Pure] public function __construct(EntityManagerInterface $entityManager, CommandeRepository $commandeRepository)
    {
        parent::__construct($entityManager);
        $this->commandeRepository = $commandeRepository;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/admin/commande", name="app_commande_admin")
     */
    public function Commande(): Response
    {
        $commandeList = $this->commandeRepository->findBy(array("status" => 0));
        return $this->render("commande/adminCommande.html.twig", [
            "commandeList" => $commandeList
        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/admin/commande/{status<^[1-2]{1}$>}/{id<^[1-9]{1}[0-9]*$>}", name="app_commande_validate")
     */
    public function validate(int $status, int $id): Response
    {
        $commande = $this->commandeRepository->findOneBy(array("id" => $id));
        $commande->setStatus($status);
        $this->entityManager->persist($commande);
        $this->entityManager->flush();

        return $this->redirectToRoute("app_commande_admin");
    }

}