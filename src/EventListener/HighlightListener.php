<?php

namespace App\EventListener;

use App\Entity\Game;
use App\Entity\Highlight;
use App\Enum\HighlightType;
use App\Enum\TeamSide;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: Highlight::class)]
class HighlightListener
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function prePersist(Highlight $highlight): void
    {
        // dd($highlight->getTeamCompeting()->getSide());
        $teamSide = TeamSide::tryFrom($highlight->getTeamCompeting()->getSide());

        if (empty($teamSide)) {
            return;
        }

        $isSideHome = $teamSide === TeamSide::HOME_ID;

        $field = $isSideHome ? 'teamCompetingHome' : 'teamCompetingVisitor';
        $game = $this->em->getRepository(Game::class)->findOneBy([$field => $highlight->getTeamCompeting()->getId()]);

        $highlightType = HighlightType::from($highlight->getType());
        if ($isSideHome) {
            $game->setScoreHome($game->getScoreHome() + $highlightType->getPoints());
        } else {
            $game->setScoreVisitor($game->getScoreVisitor() + $highlightType->getPoints());
        }

        $this->em->flush();
    }
}
