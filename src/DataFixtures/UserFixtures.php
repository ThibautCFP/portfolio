<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user
            ->setLastName("Brunet")
            ->setFirstName("Thibaut")
            ->setEmail("admin@test.com")
            ->setPassword($this->hasher->hashPassword($user, 'Test1234'))
            ->setRoles(["ROLE_ADMIN"]);

        $user2 = new User();
        $user2
            ->setLastName('CFP')
            ->setFirstName('CHARMILLES')
            ->setEmail('cfp@test.com')
            ->setPassword($this->hasher->hashPassword($user2, 'cfpcharmilles'))
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->persist($user2);
        $manager->flush();
    }
}
