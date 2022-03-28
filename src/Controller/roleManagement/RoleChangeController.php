<?php

namespace App\Controller\roleManagement;

use App\Controller\Controller;
use App\Handler\ChangeRoleFormHandler;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleChangeController extends Controller
{
    /**
     * @Route("/roleSubmit", name="app_roleForm")
     */
    public function changeRoles(Request $request, ManagerRegistry $registry): Response
    {
        (new ChangeRoleFormHandler($request,$registry,$this->entityManager))->process();
        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}