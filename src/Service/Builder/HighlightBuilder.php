<?php

namespace App\Service\Builder;

use App\Dto\CreateHighlightDto;
use App\Entity\Highlight;
use App\Entity\TeamCompeting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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

        if ($highlightDto->type->isDisciplinaryHighlight()) {
            if (empty($highlightDto->playerSanctioned)) {
                throw new BadRequestException('A Player sanctioned is required to create a disciplinary highlight. (field required: playerSanctioned)', 400);
            }
            $highlight->setPlayerSanctioned($highlightDto->playerSanctioned);
        }

        if ($highlightDto->type->isSubstitutionHighlight()) {
            if (empty($highlightDto->playerSubstituted) || empty($highlightDto->playerSubstitute)) {
                throw new BadRequestException('A Player substituted and a player substitute are required to create a substitution highlight. (field required: playerSubstituted, playerSubstitute)', 400);
            }
            $highlight->setPlayerSubstituted($highlightDto->playerSubstituted);
            $highlight->setPlayerSubstitute($highlightDto->playerSubstitute);
        }

        $this->em->persist($highlight);

        return $highlight;
    }
}
