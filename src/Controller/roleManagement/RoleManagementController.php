<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleManagementController extends AbstractController
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/roleManagement/{page<^[1-9]{1}[0-9]*$>}", name="app_roleManagement")
     */

    public function roleManagement(int $page, ManagerRegistry $registry): Response
    {
        $user = new UserRepository($registry);
        $user = $user->find10($page);
        return $this->render('roleManagement/roleManagement.html.twig', [
            "userList" => $user,
            "quantity" => count($user) - 1
        ]);
    }
}