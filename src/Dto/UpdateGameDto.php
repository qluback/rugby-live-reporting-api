<?php

namespace App\Dto;

// use Symfony\Component\Validator\Constraints as Assert;

class UpdateGameDto
{
    public function __construct(
        // #[Assert\NotBlank]
        // #[Assert\Type('int')]
        public readonly ?int $time,
        public readonly ?int $halfTime,
        public readonly ?int $status,
    ) {
    }
}
