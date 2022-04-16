<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbUsers = 1; $nbUsers <= 10; $nbUsers++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
            $user->setLastName($faker->lastName);
            $user->setFirstName($faker->firstName);
            $user->setUsername($faker->userName);
            $user->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($user);
        }

        $user = new User();
        $user->setEmail($faker->email);
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $user->setLastName("Admin");
        $user->setFirstName("Super");
        $user->setUsername("SuperAdmin");
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        $user = new User();
        $user->setEmail($faker->email);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, 'azerty'));
        $user->setLastName("Admin");
        $user->setFirstName("Just");
        $user->setUsername("Admin");
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        $manager->flush();
    }

}