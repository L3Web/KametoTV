<?php

namespace App\Controller\roleManagement;

use App\Entity\User;
use App\Handle\ChangeRoleFormHandler;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleChangeController extends AbstractController
{
    /**
     * @Route("/roleSubmit", name="app_roleForm")
     */
    public function changeRoles(Request $request, ManagerRegistry $registry, EntityManagerInterface $entityManager): Response
    {
        (new ChangeRoleFormHandler($request,$registry,$entityManager))->process();
        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}