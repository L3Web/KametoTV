<?php

namespace App\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SendingPasswordResetEmailController
{
    private Form $form;
    private Request $request;

    public function __construct(Request $request, Form $form)
    {
        $this->form = $form;
        $this->request = $request;
    }

    public function process(): bool|array
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return array(
                "email" => $this->form->get('email')->getData(),
                "username" => $this->form->get('username')->getData(),
            );
        }
        return false;
    }
}