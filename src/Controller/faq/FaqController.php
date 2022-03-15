<?php

namespace App\Controller\faq;

use App\Controller\Controller;
use App\Entity\Faq;
use App\Repository\FaqRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends Controller
{
    /**
     * @Route("/faq", name="app_faq")
     */

    public function faq(ManagerRegistry $doctrine) : Response
    {
        $faqRepository = new FaqRepository($doctrine);
        $res = $faqRepository->get10Faq();
        return $this->render('faq/faq.html.twig', [
            "faqAll"=>$res,
            "quantity"=>count($res)-1
        ]);
    }

    #[Route('/faq/{id}', name: 'app_faqDel')]
    public function deleteFaq(Faq $faq): Response
    {
        $this->entityManager->remove($faq);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_faq');
    }

}