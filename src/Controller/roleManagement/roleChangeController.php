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

class roleChangeController extends AbstractController
{
    /**
     * @Route("/roleSubmit", methods={"POST"}, name="app_roleForm")
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