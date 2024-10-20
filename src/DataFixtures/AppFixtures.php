<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Highlight;
use App\Entity\Team;
use App\Entity\TeamCompeting;
use App\Enum\TeamSide;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $teams = ['Athis-Mons', 'Juvisy', 'Lognes', 'Provins', 'Domont'];
        $newTeams = [];
        foreach ($teams as $teamName) {
            $newTeam = new Team();
            $newTeam->setName($teamName);
            array_push($newTeams, $newTeam);
            $manager->persist($newTeam);
        }

        $teamCompeting1 = new TeamCompeting();
        $teamCompeting1->setTeam($newTeams[0]);
        $teamCompeting1->setSide(TeamSide::HOME_ID->value);
        $manager->persist($teamCompeting1);
        $teamCompeting2 = new TeamCompeting();
        $teamCompeting2->setTeam($newTeams[1]);
        $teamCompeting2->setSide(TeamSide::VISITOR_ID->value);
        $manager->persist($teamCompeting2);

        $newGame = new Game();
        $newGame->setTeamCompetingHome($teamCompeting1);
        $newGame->setTeamCompetingVisitor($teamCompeting2);
        $newGame->setScoreHome(0);
        $newGame->setScoreVisitor(0);
        $manager->persist($newGame);

        $manager->flush();

        $highlights = [['convertedTry', 13, $teamCompeting1], ['penaltyTry', 27, $teamCompeting2], ['dropGoal', 60, $teamCompeting2]];
        $newHighlights = [];
        foreach ($highlights as $highlight) {
            $newHighlight = new Highlight();
            $newHighlight->setType($highlight[0]);
            $newHighlight->setMinute($highlight[1]);
            $newHighlight->setTeamCompeting($highlight[2]);
            array_push($newHighlights, $newHighlight);
            $manager->persist($newHighlight);
        }

        $teamCompeting1->addHighlight($newHighlights[0]);
        $teamCompeting1->addHighlight($newHighlights[1]);
        $teamCompeting2->addHighlight($newHighlights[2]);

        $manager->flush();
    }
}
