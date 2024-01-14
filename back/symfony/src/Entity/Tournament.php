<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\LaunchTournamentController;
use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
#[ApiResource()]
#[Get()]
#[GetCollection()]
#[Post()]
#[Delete()]
#[Patch()]
#[Patch(
    controller: LaunchTournamentController::class,
    read: false,
    uriTemplate: "/tournaments/{id}/launch"
)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $game = null;

    #[ORM\Column()]
    private ?bool $launched = null;


    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Matche::class, orphanRemoval: true)]
    private Collection $matche;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'tournaments')]
    private Collection $Team;

    #[ORM\ManyToOne(inversedBy: 'tournaments')]
    private ?User $CreatorTournament = null;

    public function __construct()
    {
        $this->matche = new ArrayCollection();
        $this->Team = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGame(): ?string
    {
        return $this->game;
    }

    public function setGame(string $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getLaunched()
    {
        return $this->launched;
    }

    public function setLaunched(bool $launched)
    {
        $this->launched = $launched;
        return $this;
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getMatche(): Collection
    {
        return $this->matche;
    }

    public function addMatche(Matche $matche): static
    {
        if (!$this->matche->contains($matche)) {
            $this->matche->add($matche);
            $matche->setTournament($this);
        }

        return $this;
    }

    public function removeMatche(Matche $matche): static
    {
        if ($this->matche->removeElement($matche)) {
            // set the owning side to null (unless already changed)
            if ($matche->getTournament() === $this) {
                $matche->setTournament(null);
            }
        }

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

    public function getCreatorTournament(): ?User
    {
        return $this->CreatorTournament;
    }

    public function setCreatorTournament(?User $CreatorTournament): static
    {
        $this->CreatorTournament = $CreatorTournament;

        return $this;
    }
}
