<?php

namespace App\Controller\roleManagement;

use App\Controller\Controller;
use App\Entity\User;
use App\Handler\ChangeRoleFormHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleChangeController extends Controller
{
    /**
     * @Route("/{_locale<%app.supported_locales%>}/roleSubmit", name="app_roleForm")
     */
    public function changeRoles(Request $request, ManagerRegistry $registry): Response
    {
        (new ChangeRoleFormHandler($request,$registry,$this->entityManager))->process();
        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}