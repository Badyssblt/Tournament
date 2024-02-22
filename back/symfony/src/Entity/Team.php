<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AddUserToTeamController;
use App\Controller\CreateTeamController;
use App\Controller\DeleteUserToTeamController;
use App\Controller\MyTeamController;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
#[Post(
    controller: CreateTeamController::class,
    read: false
)]
#[Get(
    normalizationContext: ['groups' => ['read:team:item']],
    security: "object.Creator == user"
)]
#[Get(
    controller: MyTeamController::class,
    read: false,
    uriTemplate: "/team/myteam",
    openapiContext: [
        "summary" => "Récupère l'équipe d'un utilisateur"
    ],
    normalizationContext: ['groups' => ['read:team:item']]
)]
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
    #[Groups(['read:Tournament', 'read:team:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Tournament', 'read:team:item'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'teams')]
    #[Groups(['read:team:item'])]
    private Collection $User;

    #[ORM\OneToMany(mappedBy: 'targetTeam', targetEntity: TeamJoinRequest::class, orphanRemoval: true)]
    private Collection $teamJoinRequests;

    #[ORM\ManyToOne(inversedBy: 'Creator')]
    #[ORM\JoinColumn(nullable: false)]
    public ?User $Creator = null;


    #[ORM\ManyToMany(targetEntity: Matche::class, mappedBy: 'Team')]
    private Collection $matches;


    #[ORM\ManyToMany(targetEntity: Tournament::class, mappedBy: 'Team')]
    private Collection $tournaments;

    #[ORM\OneToMany(mappedBy: 'winnerTournament', targetEntity: Tournament::class)]
    private Collection $winnerTournament;

    #[ORM\Column(nullable: true)]
    private ?float $Score = null;

    #[ORM\OneToMany(mappedBy: 'WinnerMatche', targetEntity: Matche::class)]
    private Collection $WinnerMatche;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->teamJoinRequests = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
        $this->winnerTournament = new ArrayCollection();
        $this->WinnerMatche = new ArrayCollection();
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

    /**
     * @return Collection<int, Tournament>
     */
    public function getWinnerTournament(): Collection
    {
        return $this->winnerTournament;
    }

    public function addWinnerTournament(Tournament $winnerTournament): static
    {
        if (!$this->winnerTournament->contains($winnerTournament)) {
            $this->winnerTournament->add($winnerTournament);
            $winnerTournament->setWinnerTournament($this);
        }

        return $this;
    }

    public function removeWinnerTournament(Tournament $winnerTournament): static
    {
        if ($this->winnerTournament->removeElement($winnerTournament)) {
            // set the owning side to null (unless already changed)
            if ($winnerTournament->getWinnerTournament() === $this) {
                $winnerTournament->setWinnerTournament(null);
            }
        }

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->Score;
    }

    public function setScore(?float $Score): static
    {
        $this->Score = $Score;

        return $this;
    }

    /**
     * @return Collection<int, Matche>
     */
    public function getWinnerMatche(): Collection
    {
        return $this->WinnerMatche;
    }

    public function addWinnerMatche(Matche $winnerMatche): static
    {
        if (!$this->WinnerMatche->contains($winnerMatche)) {
            $this->WinnerMatche->add($winnerMatche);
            $winnerMatche->setWinnerMatche($this);
        }

        return $this;
    }

    public function removeWinnerMatche(Matche $winnerMatche): static
    {
        if ($this->WinnerMatche->removeElement($winnerMatche)) {
            // set the owning side to null (unless already changed)
            if ($winnerMatche->getWinnerMatche() === $this) {
                $winnerMatche->setWinnerMatche(null);
            }
        }

        return $this;
    }
}
