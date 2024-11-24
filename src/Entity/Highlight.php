<?php

namespace App\Entity;

use App\Repository\HighlightRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: HighlightRepository::class)]
class Highlight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getGame'])]
    private ?string $type = null;

    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?int $minute = null;

    #[ORM\ManyToOne(inversedBy: 'highlights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeamCompeting $teamCompeting = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['getGame'])]
    private ?int $playerSanctioned = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['getGame'])]
    private ?int $playerSubstituted = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['getGame'])]
    private ?int $playerSubstitute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): static
    {
        $this->minute = $minute;

        return $this;
    }

    public function getTeamCompeting(): ?TeamCompeting
    {
        return $this->teamCompeting;
    }

    public function setTeamCompeting(?TeamCompeting $teamCompeting): static
    {
        $this->teamCompeting = $teamCompeting;

        return $this;
    }

    public function getPlayerSanctioned(): ?int
    {
        return $this->playerSanctioned;
    }

    public function setPlayerSanctioned(?int $playerSanctioned): static
    {
        $this->playerSanctioned = $playerSanctioned;

        return $this;
    }

    public function getPlayerSubstituted(): ?int
    {
        return $this->playerSubstituted;
    }

    public function setPlayerSubstituted(?int $playerSubstituted): static
    {
        $this->playerSubstituted = $playerSubstituted;

        return $this;
    }

    public function getPlayerSubstitute(): ?int
    {
        return $this->playerSubstitute;
    }

    public function setPlayerSubstitute(?int $playerSubstitute): static
    {
        $this->playerSubstitute = $playerSubstitute;

        return $this;
    }
}
