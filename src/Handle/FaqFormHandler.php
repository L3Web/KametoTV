<?php

namespace App\Handle;

use App\Entity\Faq;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class FaqFormHandler
{
    private Form $form;
    private Faq $faq;
    private Request $request;
    private EntityManagerInterface $entityManager;

    public function __construct(Form $form, Faq $faq, Request $request, EntityManagerInterface $entityManager)
    {
        $this->form=$form;
        $this->faq=$faq;
        $this->request=$request;
        $this->entityManager=$entityManager;
    }

    public function process(): bool
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            $this->entityManager->persist($this->faq);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}