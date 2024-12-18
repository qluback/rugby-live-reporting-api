<?php

namespace App\Service\Builder;

use App\Entity\Team;
use App\Entity\TeamCompeting;
use App\Enum\TeamSide;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class TeamCompetingBuilder
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function createTeamCompeting(int $teamId, TeamSide $teamSide)
    {
        $team = $this->em->getRepository(Team::class)->find($teamId);

        if (null === $team) {
            throw new EntityNotFoundException(sprintf('Team not found with ID %s', $teamId), 400);
        }

        $teamCompeting = new TeamCompeting();
        $teamCompeting->setTeam($team);
        $teamCompeting->setSide($teamSide->value);

        $this->em->persist($teamCompeting);

        return $teamCompeting;
    }
}
