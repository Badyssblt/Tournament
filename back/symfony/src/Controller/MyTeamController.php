<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MyTeamController extends AbstractController
{
    public function __invoke(Security $security, TeamRepository $teamRepository, SerializerInterface $serializer)
    {
        $user = $security->getUser();
        if (!$user) {
            return $this->json(['message' => 'Veuillez vous connectez'], Response::HTTP_UNAUTHORIZED);
        }

        $team = $teamRepository->findOneBy(['Creator' => $user]);
        if ($team) {
            $teamData = $serializer->serialize($team, "json", ['groups' => 'read:team:item']);
            return $this->json(json_decode($teamData, true));
        }

        if ($team) {
            return $this->json($team);
        }

        return null;
    }
}
