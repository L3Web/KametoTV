<?php

namespace App\Controller\roleManagement;

use App\Controller\Controller;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleDeleteController extends Controller
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/roleDelete/{id<^[1-9]{1}[0-9]*$>}", name="app_roleDelete")
     */

    public function delete(int $id, UserRepository $userRepository) : Response
    {
        $user = $userRepository->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}