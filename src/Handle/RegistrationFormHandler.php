<?php

namespace App\Handle;

use App\Entity\User;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationFormHandler
{
    private Form $form;
    private User $user;
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;
    private MailerService $mailerService;
    private Request $request;

    public function __construct(Request $request, Form $form, User $user, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailerService)
    {
        $this->form = $form;
        $this->user = $user;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
        $this->mailerService = $mailerService;
        $this->request=$request;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function process() : bool
    {
        $this->form->handleRequest($this->request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->user->setCreatedAt(new \DateTimeImmutable("now"));
            // encode the plain password
            $this->user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $this->user,
                    $this->form->get('plainPassword')->getData()
                )
            );
            //to be deleted after test
            if ($this->form['admin']->getData() === true) {
                $this->user->addRole('ROLE_ADMIN');
            }
            $this->entityManager->persist($this->user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email
            $this->mailerService->sendEmail("Welcome", $this->user->getEmail(), "emails/signUp.html.twig", [
                "user" => $this->user
            ]);
            return true;
        }
        return false;
    }

}