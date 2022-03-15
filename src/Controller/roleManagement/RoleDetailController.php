<?php

namespace App\Controller\roleManagement;

use App\Entity\User;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoleDetailController extends AbstractController
{

    private array $hierarchy;

    public function __construct()
    {
        $this->hierarchy = $this->getParameter('security.role_hierarchy.roles');
        unset($this->hierarchy["ROLE_SUPER_ADMIN"]);
    }

    /**
     * @Route("/roleManagement/details/{id<^[1-9]{1}[0-9]*$>}", name="app_roleDetails")
     */

    public function roleDetail(int $id, ManagerRegistry $registry): Response
    {
        $user = $registry->getRepository(User::class)->find($id);
        if (is_null($user)) {
            throw $this->createNotFoundException("User don't exist");
        }
        $this->sortRoles($user);
        return $this->render('roleManagement/roleManagementDetail.html.twig', [
            "user" => $user,
            "hierarchyList" => array_keys($this->hierarchy)
        ]);
    }

    private function sortRoles($user) : void
    {
        //A modifier
        foreach ($user->getRoles() as $value) {
            if (key_exists($value, $this->hierarchy)) {
                unset($this->hierarchy[$value]);
            }
        }
    }
}