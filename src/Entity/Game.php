<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getGames', 'getGame'])]
    #[Assert\Valid]
    private ?TeamCompeting $teamCompetingHome = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getGames', 'getGame'])]
    #[Assert\Valid]
    private ?TeamCompeting $teamCompetingVisitor = null;

    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $scoreHome = 0;

    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $scoreVisitor = 0;

    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $time = 0;

    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $halfTime = 1;

    #[ORM\Column]
    #[Groups(['getGames', 'getGame'])]
    private ?int $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamCompetingHome(): ?TeamCompeting
    {
        return $this->teamCompetingHome;
    }

    public function setTeamCompetingHome(TeamCompeting $teamCompetingHome): static
    {
        $this->teamCompetingHome = $teamCompetingHome;

        return $this;
    }

    public function getTeamCompetingVisitor(): ?TeamCompeting
    {
        return $this->teamCompetingVisitor;
    }

    public function setTeamCompetingVisitor(TeamCompeting $teamCompetingVisitor): static
    {
        $this->teamCompetingVisitor = $teamCompetingVisitor;

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

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getHalfTime(): ?int
    {
        return $this->halfTime;
    }

    public function setHalfTime(int $halfTime): static
    {
        $this->halfTime = $halfTime;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
