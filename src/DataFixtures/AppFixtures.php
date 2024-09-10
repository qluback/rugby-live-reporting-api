<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $teams = ['Athis-Mons', 'Juvisy', 'Lognes', 'Provins', 'Domont'];
        foreach ($teams as $teamName) {
          $newTeam = new Team();
          $newTeam->setName($teamName);
          $manager->persist($newTeam);
        }

        $manager->flush();
    }
}
