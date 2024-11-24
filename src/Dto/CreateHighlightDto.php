<?php

namespace App\Dto;

use App\Enum\HighlightType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateHighlightDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public readonly int $teamCompetingId,
        #[Assert\NotBlank]
        #[Assert\Type(HighlightType::class)]
        public readonly HighlightType $type,
        #[Assert\NotBlank]
        #[Assert\Type('int')]
        public readonly int $minute,
        #[Assert\Type('int')]
        public readonly ?int $playerSanctioned,
        #[Assert\Type('int')]
        public readonly ?int $playerSubstituted,
        #[Assert\Type('int')]
        public readonly ?int $playerSubstitute,
    ) {
    }
}
