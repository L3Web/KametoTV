<?php

namespace App\Controller\faq;

use App\Controller\Controller;
use App\Entity\Faq;
use App\Form\AddFaqFormType;
use App\Handler\FaqFormHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FaqAddController extends Controller
{

    /**
     * @Route("/{_locale<%app.supported_locales%>}/faq/add", name="app_faqAdd")
     */
    public function addFaq(Request $request) : Response
    {
        $faq= new Faq();
        $form = $this->createForm(AddFaqFormType::class, $faq);
        $formHandler = (new FaqFormHandler($form, $faq, $request, $this->entityManager))->process();
        if($formHandler) {
            return $this->redirectToRoute("app_faq");
        }
        return $this->renderForm('faq/faqAdd.html.twig',[
            'formFaq'=>$form
        ]);
    }
}