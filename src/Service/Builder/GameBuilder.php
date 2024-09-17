<?php

namespace App\Service\Builder;

use App\Entity\Game;
use App\Entity\Team;
use App\Entity\TeamCompeting;
use Doctrine\ORM\EntityManagerInterface;

class GameBuilder {
  public function __construct(private EntityManagerInterface $em)
  {
  }

  public function createGame(TeamCompeting $teamHome, TeamCompeting $teamVisitor) {
    $game = new Game();
    $game->setTeamCompetingHome($teamHome);
    $game->setTeamCompetingVisitor($teamVisitor);

    $this->em->persist($game);

    return $game;
  }
}