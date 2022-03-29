<?php

namespace App\Controller\registration;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Handler\RegistrationFormHandler;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     *
     * @throws TransportExceptionInterface
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $formHandler = (new RegistrationFormHandler($request, $form, $user, $userPasswordHasher, $entityManager, $mailerService))->process();
        if ($formHandler) {
            return $this->render('home.html.twig', [
                'message' => 'register success'
            ]);
        }
        return $this->renderForm('registration/register.html.twig', [
            'formRegister' => $form
        ]);
    }
}
