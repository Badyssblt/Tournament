<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\FindUserByEmailController;
use App\Controller\RegisterController;
use App\Controller\VerifyAccountController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource()]
#[Post(
    controller: RegisterController::class,
    read: false
)]
#[Patch(
    controller: VerifyAccountController::class,
    uriTemplate: '/users/{id}/verify/{code}',
    read: false,
)]
#[Get()]
#[Get(
    controller: FindUserByEmailController::class,
    read: false,
    uriTemplate: "/user/get/{email}",
    openapiContext: [
        'parameters' => [
            [
                'name' => 'email',
                'in' => 'path',
                'required' => true,
                'schema' => [
                    'type' => 'string',
                    'format' => 'email',
                    'example' => 'test@example.com',
                    'description' => "L'email qui est recherché"
                ]
            ],
            [
                'name' => 'id',
                'in' => 'path',
                'required' => false,
                'schema' => [
                    'type' => 'integer',
                    'format' => 'integer',
                ]
            ]
        ]
    ]
)]

#[UniqueEntity(fields: "email", message: "Un utilisateur avec cet adresse email existe déjà.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['create:User', 'read:item:team', 'read:Tournament'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read:Tournament', 'read:team:item'])]
    #[Groups(['read:Tournament', 'read:team:item'])]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['create:User'])]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Team::class, mappedBy: 'User')]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'requestingUser', targetEntity: TeamJoinRequest::class, orphanRemoval: true)]
    private Collection $teamJoinRequests;

    #[ORM\OneToMany(mappedBy: 'Creator', targetEntity: Team::class)]
    private Collection $Creator;

    #[ORM\OneToMany(mappedBy: 'CreatorTournament', targetEntity: Tournament::class)]
    private Collection $tournaments;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Tournament', 'read:team:item'])]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $verification_code = null;

    #[ORM\Column]
    private ?bool $is_verified = null;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->teamJoinRequests = new ArrayCollection();
        $this->Creator = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->addUser($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            $team->removeUser($this);
        }

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
            $teamJoinRequest->setRequestingUser($this);
        }

        return $this;
    }

    public function removeTeamJoinRequest(TeamJoinRequest $teamJoinRequest): static
    {
        if ($this->teamJoinRequests->removeElement($teamJoinRequest)) {
            // set the owning side to null (unless already changed)
            if ($teamJoinRequest->getRequestingUser() === $this) {
                $teamJoinRequest->setRequestingUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getCreator(): Collection
    {
        return $this->Creator;
    }

    public function addCreator(Team $creator): static
    {
        if (!$this->Creator->contains($creator)) {
            $this->Creator->add($creator);
            $creator->setCreator($this);
        }

        return $this;
    }

    public function removeCreator(Team $creator): static
    {
        if ($this->Creator->removeElement($creator)) {
            // set the owning side to null (unless already changed)
            if ($creator->getCreator() === $this) {
                $creator->setCreator(null);
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
        }

        return $this;
    }

    public function removeTournament(Tournament $tournament): static
    {
        if ($this->tournaments->removeElement($tournament)) {
            // set the owning side to null (unless already changed)
        }

        return $this;
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

    public function getVerificationCode(): ?int
    {
        return $this->verification_code;
    }

    public function setVerificationCode(int $verification_code): static
    {
        $this->verification_code = $verification_code;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setisVerified(bool $is_verified): static
    {
        $this->is_verified = $is_verified;

        return $this;
    }
}
