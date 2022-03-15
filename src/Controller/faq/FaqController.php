<?php

namespace App\Controller\faq;

use App\Entity\Faq;
use App\Repository\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
    /**
     * @Route("/faq", name="app_faq")
     */

    public function faq(ManagerRegistry $doctrine) : Response
    {
        $faqRepository = new FaqRepository($doctrine);
        $res = $faqRepository->getAllFaq();
        return $this->render('faq/faq.html.twig', [
            "faqAll"=>$res,
            "quantity"=>count($res)-1
        ]);
    }

    #[Route('/faq/{id}', name: 'app_faqDel')]
    public function deleteFaq(Faq $faq, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($faq);
        $entityManager->flush();

        return $this->redirectToRoute('app_faq');
    }

}