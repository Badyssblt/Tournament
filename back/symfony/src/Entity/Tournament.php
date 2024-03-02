<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\GetCollectionTournamentController;
use App\Controller\GetTournamentMatcheController;
use App\Controller\LaunchTournamentController;
use App\Controller\NextRoundController;
use App\Controller\RetrieveTournamentController;
use App\Controller\SearchTournamentController;
use App\Repository\TournamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints\TeamsCount;

#[ORM\Entity(repositoryClass: TournamentRepository::class)]
#[ApiResource()]
#[Get(
    normalizationContext: ['groups' => ['read:Tournament']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['read:collection']],
    controller: GetCollectionTournamentController::class,
    read: false
)]
#[GetCollection(
    uriTemplate: "/tournament/myTournament",
    controller: RetrieveTournamentController::class,
    read: false
)]

#[GetCollection(
    uriTemplate: "tournaments/{id}/getMatch",
    read: false,
    controller: GetTournamentMatcheController::class
)]
#[Post()]
#[Delete()]
#[Patch()]
#[Patch(
    controller: LaunchTournamentController::class,
    read: false,
    uriTemplate: "/tournaments/{id}/launch"
)]
#[Patch(
    controller: NextRoundController::class,
    read: false,
    uriTemplate: "/tournaments/{id}/nextRound/{roundId}",
    openapiContext: [
        "summary" => "Génère les matchs du prochain round.",
    ]
)]
#[GetCollection(
    controller: SearchTournamentController::class,
    read: false,
    openapiContext: [
        'parameters' => [
            [
                'name' => 'category',
                'in' => 'path',
                'required' => true,
                'schema' => [
                    'type' => 'string',
                    'example' => 'Categorie',
                    'description' => "Categorie recherché"
                ]
                ]
                
        ]
    ]
)]
class Tournament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?string $name = null;

    #[ORM\Column()]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?bool $launched = null;


    #[ORM\OneToMany(mappedBy: 'tournament', targetEntity: Matche::class, orphanRemoval: true)]
    #[Groups(['read:Tournament'])]
    private Collection $matche;

    #[ORM\ManyToMany(targetEntity: Team::class, inversedBy: 'tournaments')]
    #[Groups(['read:Tournament'])]
    #[TeamsCount]
    private Collection $Team;

    #[ORM\ManyToOne(inversedBy: 'tournaments')]
    #[Groups(['read:Tournament'])]
    private ?User $CreatorTournament = null;

    #[ORM\ManyToOne(inversedBy: 'winnerTournament')]
    #[Groups(['read:Tournament'])]
    private ?Team $winnerTournament = null;

    #[ORM\Column(length: 1000)]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?int $maxTeams = null;

    #[ORM\Column]
    #[Groups(['read:collection', 'read:Tournament'])]
    private ?bool $visibility = null;

    #[ORM\ManyToMany(targetEntity: Game::class, inversedBy: 'tournaments')]
    #[Groups(['read:collection', 'read:Tournament'])]
    private Collection $game;

    public function __construct()
    {
        $this->matche = new ArrayCollection();
        $this->Team = new ArrayCollection();
        $this->game = new ArrayCollection();
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

    public function getWinnerTournament(): ?Team
    {
        return $this->winnerTournament;
    }

    public function setWinnerTournament(?Team $winner): static
    {
        $this->winnerTournament = $winner;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getMaxTeams(): ?int
    {
        return $this->maxTeams;
    }

    public function setMaxTeams(int $maxTeams): static
    {
        $this->maxTeams = $maxTeams;

        return $this;
    }

    public function isVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): static
    {
        if (!$this->game->contains($game)) {
            $this->game->add($game);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        $this->game->removeElement($game);

        return $this;
    }

}
