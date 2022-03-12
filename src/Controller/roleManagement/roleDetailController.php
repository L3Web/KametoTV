<?php

namespace App\Controller\roleManagement;

use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class roleDetailController extends AbstractController
{

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


        //A modifier
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
}