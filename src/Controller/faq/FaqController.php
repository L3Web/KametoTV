<?php

namespace App\Controller\faq;

use App\Entity\Faq;
use App\Form\AddFaqFormType;
use App\Repository\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/faq/add', name: 'AddFaq')]
    public function addFaq(Request $request,EntityManagerInterface $entityManager) : Response
    {
        $faq = new Faq();
        $form = $this->createForm(AddFaqFormType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($faq);
            $entityManager->flush();

            return $this->redirectToRoute('app_faq');;
        }

        return $this->renderForm('faq/faqAdd.html.twig',[
            'formFaq'=>$form
        ]);
    }
}