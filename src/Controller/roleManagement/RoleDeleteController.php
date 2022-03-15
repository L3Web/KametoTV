<?php

namespace App\Controller\roleManagement;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleDeleteController extends AbstractController
{
    /**
     * @Route("/roleDelete/{id<^[1-9]{1}[0-9]*$>}", name="app_roleDelete")
     */

    public function delete(int $id, ManagerRegistry $doctrine) : Response
    {
        $entityManager=$doctrine->getRepository(User::class);
        $user = $entityManager->find($id);
        var_dump($user);
        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}