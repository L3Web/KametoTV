<?php

namespace App\Controller\informations;

use App\Controller\Controller;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class accountInformationController extends Controller
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/account/informations", name="app_informations")
     */
    public function show(UserInterface $user, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(array("id" => $user->getId()));

        return $this->render("informations/accountInformation.html.twig", [
            "user" => $user
        ]);
    }
}