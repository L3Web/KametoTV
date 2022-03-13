<?php

namespace App\Controller\registration;

use App\Entity\User;
use App\Form\RegistrationFormType;
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
     * @throws TransportExceptionInterface
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerService $mailerService): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTimeImmutable("now"));
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //to be deleted after test
            if ($form['admin']->getData() === true) {
                $user->addRole('ROLE_ADMIN');
            }
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $mailerService->sendEmail("Welcome", $user->getEmail(), "emails/signUp.html.twig", [
                "user"=>$user
            ]);
            return $this->render('home.html.twig', [
                'message'=>'register success'
            ]);
        }
        return $this->renderForm('registration/register.html.twig', [
            'formRegister'=>$form
        ]);
    }
}
