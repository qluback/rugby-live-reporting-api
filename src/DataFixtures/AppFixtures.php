<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Highlight;
use App\Entity\Team;
use App\Entity\TeamCompeting;
use App\Enum\HighlightType;
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

        $highlights = [
            [
                'type' => 'convertedTry',
                'minute' => 13,
                'teamCompetingId' => $teamCompeting1,
            ],
            [
                'type' => 'yellowCard',
                'minute' => 16,
                'teamCompetingId' => $teamCompeting1,
                'playerSanctioned' => 11,
            ],
            [
                'type' => 'substitution',
                'minute' => 45,
                'teamCompetingId' => $teamCompeting1,
                'playerSubstituted' => 9,
                'playerSubstitute' => 22,
            ],
            [
                'type' => 'penaltyTry',
                'minute' => 27,
                'teamCompetingId' => $teamCompeting2,
            ],
            [
                'type' => 'dropGoal',
                'minute' => 60,
                'teamCompetingId' => $teamCompeting2,
            ],
            [
                'type' => 'redCard',
                'minute' => 16,
                'teamCompetingId' => $teamCompeting2,
                'playerSanctioned' => 7,
            ],
            [
                'type' => 'substitution',
                'minute' => 74,
                'teamCompetingId' => $teamCompeting2,
                'playerSubstituted' => 2,
                'playerSubstitute' => 16,
            ],
        ];
        $newHighlights = [];
        foreach ($highlights as $highlight) {
            $highlightType = HighlightType::from($highlight['type']);
            $newHighlight = new Highlight();
            $newHighlight->setType($highlight['type']);
            $newHighlight->setMinute($highlight['minute']);
            $newHighlight->setTeamCompeting($highlight['teamCompetingId']);

            if ($highlightType->isDisciplinaryHighlight()) {
                $newHighlight->setPlayerSanctioned($highlight['playerSanctioned']);
            }

            if ($highlightType->isSubstitutionHighlight()) {
                $newHighlight->setPlayerSubstituted($highlight['playerSubstituted']);
                $newHighlight->setPlayerSubstitute($highlight['playerSubstitute']);
            }

            array_push($newHighlights, $newHighlight);
            $manager->persist($newHighlight);
        }

        $teamCompeting1->addHighlight($newHighlights[0]);
        $teamCompeting1->addHighlight($newHighlights[1]);
        $teamCompeting1->addHighlight($newHighlights[2]);
        $teamCompeting2->addHighlight($newHighlights[3]);
        $teamCompeting2->addHighlight($newHighlights[4]);
        $teamCompeting2->addHighlight($newHighlights[5]);
        $teamCompeting2->addHighlight($newHighlights[6]);

        $manager->flush();
    }
}
