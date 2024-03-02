<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AddTeamToTournamentController extends AbstractController
{
    public function __invoke(Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, TournamentRepository $tournamentRepository, int $id, TeamRepository $teamRepository)
    {
        $content = $request->getPayload()->all();
        $data = $content['Team'][0];
        $ids = intval(explode('/', $data)[3]);
        $tournament = $tournamentRepository->find($id);
        $teams = $tournament->getTeam();
        $team = $teamRepository->find($ids);
        if(!$tournament->getTeam()->contains($team)){
            $tournament->addTeam($team);
            $manager->persist($tournament);
            $manager->flush();
            return $tournament;
        }
        $errorMessage = "Votre équipe est déjà inscrite.";
        return $this->json(['message' => $errorMessage], Response::HTTP_FORBIDDEN);

        
    }
}
