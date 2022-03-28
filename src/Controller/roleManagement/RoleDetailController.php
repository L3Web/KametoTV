<?php

namespace App\Controller\roleManagement;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleDetailController extends AbstractController
{

    private array $hierarchy;

    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->hierarchy = $roleHierarchy->getReachableRoleNames(["ROLE_SUPER_ADMIN"]);
        $key = array_search("ROLE_SUPER_ADMIN", $this->hierarchy);
        unset($this->hierarchy[$key]);
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
            "hierarchyList" => $this->hierarchy
        ]);
    }

    private function sortRoles($user): void
    {
        foreach ($user->getRoles() as $value) {
            if (($key = array_search($value, $this->hierarchy)) != false) {
                unset($this->hierarchy[$key]);
            }
        }
        $this->hierarchy = array_values($this->hierarchy);
    }
}