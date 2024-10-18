<?php

namespace App\Entity;

use App\Repository\TeamCompetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamCompetingRepository::class)]
class TeamCompeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamCompetings')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['getGames', 'getGame'])]
    #[Assert\NotNull(message: 'Team does not exist')]
    private ?Team $team = null;

    /**
     * @var Collection<int, Highlight>
     */
    #[ORM\OneToMany(targetEntity: Highlight::class, mappedBy: 'teamCompeting')]
    private Collection $highlights;

    public function __construct()
    {
        $this->highlights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return Collection<int, Highlight>
     */
    public function getHighlights(): Collection
    {
        return $this->highlights;
    }

    public function addHighlight(Highlight $highlight): static
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights->add($highlight);
            $highlight->setTeamCompeting($this);
        }

        return $this;
    }

    public function removeHighlight(Highlight $highlight): static
    {
        if ($this->highlights->removeElement($highlight)) {
            // set the owning side to null (unless already changed)
            if ($highlight->getTeamCompeting() === $this) {
                $highlight->setTeamCompeting(null);
            }
        }

        return $this;
    }
}
