<?php

namespace App\Controller\faq;

use App\Controller\Controller;
use App\Entity\Faq;
use App\Repository\FaqRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends Controller
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/faq", name="app_faq")
     */

    public function faq(FaqRepository $faqRepository) : Response
    {
        $res = $faqRepository->get5Faq();
        return $this->render('faq/faq.html.twig', [
            "faqAll"=>$res,
            "quantity"=>count($res)-1
        ]);
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/faq/del/{id<^[1-9]{1}[0-9]*$>}", name="app_faq_del")
     */

    public function deleteFaq(Faq $faq): Response
    {
        $this->entityManager->remove($faq);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_faq');
    }

}