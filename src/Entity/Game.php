<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getGame'])]
    private ?TeamCompeting $teamHome = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getGame'])]
    private ?TeamCompeting $teamVisitor = null;

    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?int $scoreHome = null;

    #[ORM\Column]
    #[Groups(['getGame'])]
    private ?int $scoreVisitor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamHome(): ?TeamCompeting
    {
        return $this->teamHome;
    }

    public function setTeamHome(TeamCompeting $teamHome): static
    {
        $this->teamHome = $teamHome;

        return $this;
    }

    public function getTeamVisitor(): ?TeamCompeting
    {
        return $this->teamVisitor;
    }

    public function setTeamVisitor(TeamCompeting $teamVisitor): static
    {
        $this->teamVisitor = $teamVisitor;

        return $this;
    }

    public function getScoreHome(): ?int
    {
        return $this->scoreHome;
    }

    public function setScoreHome(int $scoreHome): static
    {
        $this->scoreHome = $scoreHome;

        return $this;
    }

    public function getScoreVisitor(): ?int
    {
        return $this->scoreVisitor;
    }

    public function setScoreVisitor(int $scoreVisitor): static
    {
        $this->scoreVisitor = $scoreVisitor;

        return $this;
    }
}
