<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CreateGameDto
{
  public function __construct(
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public readonly int $teamHome,
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public readonly int $teamVisitor,
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public readonly int $scoreHome,
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public readonly int $scoreVisitor,
  ) {}
}
