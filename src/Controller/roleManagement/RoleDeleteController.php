<?php

namespace App\Controller\roleManagement;

use App\Controller\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleDeleteController extends Controller
{
    /**
     * @Route("/roleDelete/{id<^[1-9]{1}[0-9]*$>}", name="app_roleDelete")
     */

    public function delete(int $id, ManagerRegistry $doctrine) : Response
    {
        $user = ($doctrine->getRepository(User::class))->find($id);
        var_dump($user);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}