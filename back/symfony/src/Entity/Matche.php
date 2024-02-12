<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MatcheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
#[ApiResource]
class Matche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:tournament'])]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\ManyToOne(inversedBy: 'matche')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tournament $tournament = null;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'matches')]
    #[Groups(['read:Tournament'])]
    private Collection $Team;


    #[ORM\Column(nullable: true)]
    #[Groups(['read:Tournament'])]
    private ?int $round = null;

    #[ORM\ManyToOne(inversedBy: 'WinnerMatche')]
    #[Groups(['read:Tournament'])]
    private ?Team $WinnerMatche = null;



    public function __construct()
    {
        $date = new \DateTimeImmutable();
        $this->setDate($date);
        $this->Team = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTournament(): ?Tournament
    {
        return $this->tournament;
    }

    public function setTournament(?Tournament $tournament): static
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeam(): Collection
    {
        return $this->Team;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->Team->contains($team)) {
            $this->Team->add($team);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        $this->Team->removeElement($team);

        return $this;
    }
    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(?int $round): static
    {
        $this->round = $round;

        return $this;
    }

    public function getWinnerMatche(): ?Team
    {
        return $this->WinnerMatche;
    }

    public function setWinnerMatche(?Team $WinnerMatche): static
    {
        $this->WinnerMatche = $WinnerMatche;

        return $this;
    }
}
