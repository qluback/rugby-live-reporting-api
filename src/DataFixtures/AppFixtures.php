<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Highlight;
use App\Entity\Team;
use App\Entity\TeamCompeting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $teams = ['Athis-Mons', 'Juvisy', 'Lognes', 'Provins', 'Domont'];
        $newTeams = [];
        foreach ($teams as $teamName) {
          $newTeam = new Team();
          $newTeam->setName($teamName);
          array_push($newTeams, $newTeam);
          $manager->persist($newTeam);
        }

        $highlights = [["try", 13], ["penaltyTry", 27], ["dropGoal", 60]];
        $newHighlights = [];
        foreach ($highlights as $highlight) {
          $newHighlight = new Highlight();
          $newHighlight->setType($highlight[0]);
          $newHighlight->setMinute($highlight[1]);
          array_push($newHighlights, $newHighlight);
          $manager->persist($newHighlight);
        }

        $teamCompeting1 = new TeamCompeting();
        $teamCompeting1->setTeam($newTeams[0]);
        $manager->persist($teamCompeting1);
        $teamCompeting1->addHighlight($newHighlights[0]);
        $teamCompeting1->addHighlight($newHighlights[1]);
        $teamCompeting2 = new TeamCompeting();
        $teamCompeting2->setTeam($newTeams[1]);
        $teamCompeting2->addHighlight($newHighlights[2]);
        $manager->persist($teamCompeting2);

        $newGame = new Game();
        $newGame->setTeamHome($teamCompeting1);
        $newGame->setTeamVisitor($teamCompeting2);
        $newGame->setScoreHome(0);
        $newGame->setScoreVisitor(0);
        $manager->persist($newGame);


        $manager->flush();
    }
}
