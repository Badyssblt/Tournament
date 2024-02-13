<?php

namespace App\Controller;

use App\Entity\Matche;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class NextRoundController extends AbstractController
{
    public function __invoke(int $roundId, int $id, TournamentRepository $tournamentRepository, SerializerInterface $serializer, EntityManagerInterface $manager)
    {
        $tournament = $tournamentRepository->find($id);
        $data = $tournament->getMatche();


        $matches = [];

        foreach ($data as $matche) {
            if ($matche->getRound() == $roundId) {
                $matches[] = $matche;
            }
        }
        $nextRound = $roundId + 1;
        $matchesNextRound = [];

        foreach ($data as $match) {
            if ($match->getRound() == $nextRound) {
                $matchesNextRound[] = $match;
            }
        }

        foreach ($matches as $match) {
            if ($match->getWinnerMatche() === null) {
                return $this->json(['message' => 'Tous les matchs du round ' . $roundId . ' doivent être finis pour créer de nouveaux matchs.'], Response::HTTP_UNAUTHORIZED);
            }
        }

        if (count($matchesNextRound) > 1) {
            return $this->json(['message' => 'Les matches ont déjà été créer pour le round.', $tournament]);
        }



        $winners = [];
        foreach ($matches as $match) {
            if ($match->getRound() == $roundId && $match->getWinnerMatche() !== null) {
                array_unshift($winners, $match->getWinnerMatche());
            }
        }



        if (count($winners) == 1) {
            $tournament->setWinnerTournament($winners[0]);
            $manager->persist($tournament);
            $manager->flush();

            return $this->json(['message' => 'Le gagnant a été définie.', $tournament]);
        }

        if (count($winners) < 2) {
            return $this->json(['message' => 'Pas assez d\'équipes pour créer un nouveau match.'], Response::HTTP_BAD_REQUEST);
        }

        if (count($winners) % 2 != 0) {
            return $this->json(['message' => 'Le nombre d\'équipes doit être un multiple de 2 pour créer un nouveau match.'], Response::HTTP_BAD_REQUEST);
        }

        $pairs = array_chunk($winners, 2);

        foreach ($pairs as $pair) {
            $newMatch = new Matche();
            $newMatch->setRound($nextRound);
            foreach ($pair as $team) {
                $newMatch->addTeam($team);
            }

            $tournament->addMatche($newMatch);

            $manager->persist($newMatch);
        }

        $manager->flush();

        return $this->json(['message' => 'Nouveaux matchs créés avec succès.']);
    }
}
