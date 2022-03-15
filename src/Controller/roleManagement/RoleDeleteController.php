<?php

namespace App\Controller\roleManagement;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleDeleteController extends AbstractController
{
    /**
     * @Route("/roleDelete/{id<^[1-9]{1}[0-9]*$>}", name="app_roleDelete")
     */

    public function delete(int $id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine) : Response
    {
        $user = ($doctrine->getRepository(User::class))->find($id);
        var_dump($user);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}