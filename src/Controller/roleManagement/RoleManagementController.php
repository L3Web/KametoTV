<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleManagementController extends AbstractController
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/{_locale<%app.supported_locales%>}/admin/roleManagement/{page<^[1-9]{1}[0-9]*$>}", name="app_roleManagement")
     */

    public function roleManagement(int $page): Response
    {
        $user = $this->userRepository->find5($page);
        return $this->render('roleManagement/roleManagement.html.twig', [
            "userList" => $user,
            "quantity" => count($user) - 1,
            "hasNext" => $this->hasNext($page),
            "hasPrevious" => $this->hasPrevious($page),
            "currentPage" => $page
        ]);
    }

    public function hasNext(int $page): bool
    {
        $user = $this->userRepository->find5Next($page);
        return ($user!=null && count($user)==5);
    }

    public  function hasPrevious(int $page): bool
    {
        return $page>1;
    }

}