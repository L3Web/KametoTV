<?php

namespace App\Handler;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ChangePasswordResetHandler
{
    private Form $form;
    private Request $request;
    private User $user;
    private UserPasswordHasherInterface $userPasswordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(Form $form, Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->user = $user;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->entityManager = $entityManager;
    }

    public function process(): bool
    {
        $this->form->handleRequest($this->request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            // Encode(hash) the plain password, and set it.
            $encodedPassword = $this->userPasswordHasher->hashPassword(
                $this->user,
                $this->form->get('plainPassword')->getData()
            );

            $this->user->setPassword($encodedPassword);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }
}