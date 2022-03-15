<?php

namespace App\Controller\faq;

use App\Entity\Faq;
use App\Form\AddFaqFormType;
use App\Handle\FaqFormHandler;
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
        $faq= new Faq();
        $form = $this->createForm(AddFaqFormType::class, $faq);
        $formHandler = (new FaqFormHandler($form, $faq, $request, $entityManager))->process();
        if($formHandler) {
            return $this->redirectToRoute("app_faq");
        }
        return $this->renderForm('faq/faqAdd.html.twig',[
            'formFaq'=>$form
        ]);
    }
}