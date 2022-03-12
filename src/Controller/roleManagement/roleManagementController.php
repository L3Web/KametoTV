<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class roleManagementController extends AbstractController
{
    /**
     * @Route("/roleManagement/{page<^[1-9]{1,2}+$>}", name="app_roleManagement")
     */

    public function roleManagement(int $page, ManagerRegistry $registry) : Response
    {
        $user = new UserRepository($registry);
        $user = $user->find10($page);
        return $this->render('roleManagement/roleManagement.html.twig', [
            "userList"=>$user,
            "quantity"=>count($user)-1
        ]);
    }

    /**
     * @Route("/roleManagement/details/{id<^[1-9]+$>}", name="app_roleDetails")
     */

    public function roleDetail(int $id, ManagerRegistry $registry) : Response
    {
        $user = new UserRepository($registry);
        $user = $user->findById($id);
        if(is_null($user)) {
            throw $this->createNotFoundException("User don't exist");
        }
        return $this->render('roleManagement/roleManagementDetail.html.twig',[
            "user"=>$user
        ]);
    }
}