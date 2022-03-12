<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class roleManagementController extends AbstractController
{
    /**
     * @Route("/roleManagement/{page<^[1-9]{1,2}+$>}", name="app_roleManagement")
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

    /**
     * @Route("/roleManagement/details/{id<^[1-9]+$>}", name="app_roleDetails")
     * @throws NonUniqueResultException
     */

    public function roleDetail(int $id, ManagerRegistry $registry): Response
    {
        $user = new UserRepository($registry);
        $user = $user->findById($id);
        if (is_null($user)) {
            throw $this->createNotFoundException("User don't exist");
        }

        $hierarchy = $this->getParameter('security.role_hierarchy.roles');
        unset($hierarchy["ROLE_SUPER_ADMIN"]);

        $userRoles = $user->getRoles();

        foreach ($userRoles as $value) {
            foreach ($hierarchy as $key => $valueH) {
                if (in_array($value, $valueH) !== false) {
                    unset($hierarchy[$key]);
                }
            }
            unset($hierarchy[$value]);
        }

        $user->setRoles(array_values($userRoles));
        return $this->render('roleManagement/roleManagementDetail.html.twig', [
            "user" => $user,
            "hierarchyList" => array_keys($hierarchy)

        ]);
    }

    /**
     * @Route("/roleManagement/submit", methods={"POST"}, name="app_roleForm")
     * @throws NonUniqueResultException
     */
    public function changeRoles(Request $request, ManagerRegistry $registry, EntityManagerInterface $entityManager): Response
    {

        //A rajouter des validators

        if ($request->getMethod() == Request::METHOD_POST) {
            $user = new UserRepository($registry);
            $user = $user->findById($request->get("id"));
            if ($request->get("add") !== null) {
                foreach ($request->get("add") as $value) {
                    $user->addRole($value);
                }
            }
            if ($request->get("remove") !== null) {
                foreach ($request->get("remove") as $value) {
                    $user->removeRole($value);
                }
            }
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute("app_roleManagement", array("page" => 1));
    }
}