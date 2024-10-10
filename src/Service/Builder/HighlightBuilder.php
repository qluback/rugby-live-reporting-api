<?php

namespace App\Service\Builder;

use App\Dto\CreateHighlightDto;
use App\Entity\Highlight;
use App\Entity\TeamCompeting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class HighlightBuilder
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function createHighlight(CreateHighlightDto $highlightDto): Highlight
    {
        $teamCompeting = $this->em
            ->getRepository(TeamCompeting::class)
            ->find($highlightDto->teamCompetingId);

        if (null === $teamCompeting) {
            throw new EntityNotFoundException(sprintf('TeamCompeting not found with ID %s', $highlightDto->teamCompetingId), 400);
        }

        $highlight = new Highlight();
        $highlight->setTeamCompeting($teamCompeting);
        $highlight->setType($highlightDto->type->value);
        $highlight->setMinute($highlightDto->minute);

        $this->em->persist($highlight);

        return $highlight;
    }
}
