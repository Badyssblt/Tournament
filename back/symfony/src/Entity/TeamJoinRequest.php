<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\AcceptToJoinTeamController;
use App\Repository\TeamJoinRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamJoinRequestRepository::class)]
#[ApiResource()]
#[Post()]
#[Get()]
#[Patch(
    controller: AcceptToJoinTeamController::class,
    read: false
)]
#[GetCollection()]
class TeamJoinRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamJoinRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requestingUser = null;

    #[ORM\ManyToOne(inversedBy: 'teamJoinRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $targetTeam = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getRequestingUser(): ?User
    {
        return $this->requestingUser;
    }

    public function setRequestingUser(?User $requestingUser): static
    {
        $this->requestingUser = $requestingUser;

        return $this;
    }

    public function getTargetTeam(): ?Team
    {
        return $this->targetTeam;
    }

    public function setTargetTeam(?Team $targetTeam): static
    {
        $this->targetTeam = $targetTeam;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
