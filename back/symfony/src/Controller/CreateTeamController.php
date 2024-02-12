<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreateTeamController extends AbstractController
{
    public function __invoke(Request $request, SerializerInterface $serializer, Security $security, EntityManagerInterface $manager, TeamRepository $teamRepository)
    {
        if ($security->getUser() == null) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $user = $security->getUser();

        $content = $request->getContent();
        $team = $serializer->deserialize($content, Team::class, "json");
        $existingTeam = $teamRepository->findOneBy(['name' => $team->getName()]);

        if ($existingTeam) {
            return $this->json(['message' => 'Le nom de cette équipe existe déjà.'], Response::HTTP_CONFLICT);
        }
        $team->setCreator($user);
        $manager->persist($team);
        $manager->flush();

        return $this->json($team);

    }
}
