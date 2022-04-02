<?php

namespace App\Controller\security;

use App\Controller\Controller;
use App\Entity\ChangePassword;
use App\Form\ChangeValidPasswordFormType;
use App\Handler\ChangeValidPasswordHandler;
use App\Repository\UserRepository;
use App\Services\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ChangePasswordController extends Controller
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/account/changePassword", name="app_change_pass")
     */
    public function changePassword(UserInterface $user, UserRepository $userRepository, Request $request, MailerService $mailerService, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $userRepository->findOneBy(array("id" => $user->getId()));
        $form = $this->createForm(ChangeValidPasswordFormType::class);
        $formHandler = (new ChangeValidPasswordHandler($form, $request, $this->entityManager, $mailerService, $user, $userPasswordHasher))->process();

        if ($formHandler) {
            return $this->redirectToRoute("app_base_home");
        }

        return $this->renderForm("security/changePassword.html.twig", [
            "formChangePass" => $form
        ]);
    }
}