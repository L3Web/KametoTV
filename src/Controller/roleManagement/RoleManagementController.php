<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleManagementController extends AbstractController
{

    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @Route("/roleManagement/{page<^[1-9]{1}[0-9]*$>}", name="app_roleManagement")
     */

    public function roleManagement(int $page): Response
    {
        $user = new UserRepository($this->registry);
        $user = $user->find6($page);
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
        $user = (new UserRepository($this->registry))->find6Next($page);
        return ($user!=null && count($user)==6);
    }

    public  function hasPrevious(int $page): bool
    {
        return $page>1;
    }

}