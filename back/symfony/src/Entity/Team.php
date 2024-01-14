<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AddUserToTeamController;
use App\Controller\CreateTeamController;
use App\Controller\DeleteUserToTeamController;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource()]
#[Post(
    controller: CreateTeamController::class,
    read: false
)]
#[Get()]
#[GetCollection()]
#[Patch(
    controller: AddUserToTeamController::class,
    read: false,
    uriTemplate: "/teams/{id}/add",
    openapiContext: [
        "summary" => "Ajoute un utilisateur à une équipe",
        "description" => "Ajoute un utilisateur à une équipe"
    ]
)]
#[Patch(
    controller: DeleteUserToTeamController::class,
    read: false,
    uriTemplate: "/teams/{id}/delete",
    openapiContext: [
        "summary" => "Supprime un utilisateur d'une équipe",
        "description" => "Supprime un utilisateur d'une équipe"
    ]
)]
#[UniqueEntity(fields: "name", message: "Le nom d'équipe existe déjà.")]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'teams')]
    private Collection $User;

    #[ORM\OneToMany(mappedBy: 'targetTeam', targetEntity: TeamJoinRequest::class, orphanRemoval: true)]
    private Collection $teamJoinRequests;

    #[ORM\ManyToOne(inversedBy: 'Creator')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Creator = null;


    #[ORM\ManyToMany(targetEntity: Matche::class, mappedBy: 'team')]
    private Collection $matche;

    #[ORM\ManyToMany(targetEntity: Matche::class, mappedBy: 'Team')]
    private Collection $matches;

    #[ORM\OneToMany(mappedBy: 'Winner', targetEntity: Matche::class)]
    private Collection $Winner;

    #[ORM\ManyToMany(targetEntity: Tournament::class, mappedBy: 'Team')]
    private Collection $tournaments;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->teamJoinRequests = new ArrayCollection();
        $this->matche = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->Winner = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->User->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, TeamJoinRequest>
     */
    public function getTeamJoinRequests(): Collection
    {
        return $this->teamJoinRequests;
    }

    public function addTeamJoinRequest(TeamJoinRequest $teamJoinRequest): static
    {
        if (!$this->teamJoinRequests->contains($teamJoinRequest)) {
            $this->teamJoinRequests->add($teamJoinRequest);
            $teamJoinRequest->setTargetTeam($this);
        }

        return $this;
    }

    public function removeTeamJoinRequest(TeamJoinRequest $teamJoinRequest): static
    {
        if ($this->teamJoinRequests->removeElement($teamJoinRequest)) {
            // set the owning side to null (unless already changed)
            if ($teamJoinRequest->getTargetTeam() === $this) {
                $teamJoinRequest->setTargetTeam(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->Creator;
    }

    public function setCreator(?User $Creator): static
    {
        $this->Creator = $Creator;

        return $this;
    }

    public function isCreator(?User $user): bool
    {
        if ($this->getCreator() === $user) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matche $match): static
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);
            $match->addTeam($this);
        }

        return $this;
    }

    public function removeMatch(Matche $match): static
    {
        if ($this->matches->removeElement($match)) {
            $match->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getWinner(): Collection
    {
        return $this->Winner;
    }

    public function addWinner(Matche $winner): static
    {
        if (!$this->Winner->contains($winner)) {
            $this->Winner->add($winner);
            $winner->setWinner($this);
        }

        return $this;
    }

    public function removeWinner(Matche $winner): static
    {
        if ($this->Winner->removeElement($winner)) {
            // set the owning side to null (unless already changed)
            if ($winner->getWinner() === $this) {
                $winner->setWinner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournament>
     */
    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function addTournament(Tournament $tournament): static
    {
        if (!$this->tournaments->contains($tournament)) {
            $this->tournaments->add($tournament);
            $tournament->addTeam($this);
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): static
    {
        if ($this->tournaments->removeElement($tournament)) {
            $tournament->removeTeam($this);
        }

        return $this;
    }






}
