<?php

namespace App\Handler;

use App\Entity\User;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangeValidPasswordHandler
{

    private Form $form;
    private Request $request;
    private EntityManagerInterface $entityManager;
    private MailerService $mailerService;
    private User $user;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(Form $form, Request $request, EntityManagerInterface $entityManager, MailerService $mailerService, User $user, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->form = $form;
        $this->request = $request;
        $this->entityManager = $entityManager;
        $this->mailerService = $mailerService;
        $this->user = $user;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function process(): bool
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->changePassword = $this->form->getData();
            $this->user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $this->user,
                    $this->form->get("plainPassword")->getData()
                )
            );
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email
            $this->mailerService->sendEmail("Password change", $this->user->getEmail(), "emails/passwordChange.html.twig", [
                "user" => $this->user
            ]);

            return true;
        }

        return false;
    }
}