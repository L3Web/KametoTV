<?php

namespace App\Controller\faq;

use App\Entity\Faq;
use App\Form\AddFaqFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqAddController extends AbstractController
{

    #[Route('/faq/add', name: 'app_faqAdd')]
    public function addFaq(Request $request,EntityManagerInterface $entityManager) : Response
    {
        $faq = new Faq();
        $form = $this->createForm(AddFaqFormType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($faq);
            $entityManager->flush();

            return $this->redirectToRoute('app_faq');
        }

        return $this->renderForm('faq/faqAdd.html.twig',[
            'formFaq'=>$form
        ]);
    }
}