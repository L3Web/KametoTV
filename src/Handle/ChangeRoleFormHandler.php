<?php

namespace App\Handle;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ChangeRoleFormHandler
{
    private Request $request;
    private ManagerRegistry $registry;
    private EntityManagerInterface $entityManager;

    public function __construct(Request $request, ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->request = $request;
        $this->registry = $registry;
        $this->entityManager = $entityManager;
    }

    public function process(): bool
    {
        //A rajouter des validators

        if ($this->request->getMethod() == Request::METHOD_POST) {
            $userManager = $this->registry->getRepository(User::class);
            $user = $userManager->find($this->request->get("id"));
            if ($this->request->get("add") !== null) {
                foreach ($this->request->get("add") as $value) {
                    $user->addRole($value);
                }
            }
            if ($this->request->get("remove") !== null) {
                foreach ($this->request->get("remove") as $value) {
                    $user->removeRole($value);
                }
                $user->setRoles(array_values($user->getRoles()));
            }
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}