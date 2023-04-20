<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $skill = new Skill;
        $skill
            ->setTitle('Travail de groupe')
            ->setEnabled(true);

        $manager->persist($skill);
        $manager->flush();
    }
}
