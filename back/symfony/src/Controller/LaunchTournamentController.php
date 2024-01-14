<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LaunchTournamentController extends AbstractController
{
    public function __invoke(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $manager, Security $security, TournamentRepository $tournamentRepository)
    {
        if (!$security->getUser()) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $teamsPerMatch = 2;


        $user = $security->getUser();
        $tournament = $tournamentRepository->find($id);
        if ($tournament->getCreatorTournament() !== $user) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        if ($tournament->getLaunched()) {
            return $this->json(['message' => 'Le tournois est lancé'], Response::HTTP_UNAUTHORIZED);
        }

        $tournament->setLaunched(true);
        $teams = $tournament->getTeam();
        $numberTeams = count($teams);

        if ($numberTeams % 2 !== 0) {
            return $this->json('Le nombre d\'équipes doit être pair', Response::HTTP_BAD_REQUEST);
        }
        $teamsArray = $teams->toArray();
        shuffle($teamsArray);


        for ($i = 0; $i < count($teamsArray); $i += $teamsPerMatch) {
            $matche = new Matche();
            $matche->setRound(1);

            for ($j = 0; $j < $teamsPerMatch; $j++) {
                $matche->addTeam($teamsArray[$i + $j]);
            }

            $matche->setTournament($tournament);
            $manager->persist($matche);
        }
        $manager->flush();
        return $this->json($tournament, Response::HTTP_OK);
    }
}
