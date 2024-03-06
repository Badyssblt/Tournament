<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RetrieveTournamentController extends AbstractController
{
    public function __invoke(TournamentRepository $tournamentRepository, Security $security)
    {
        $user = $security->getUser();
        $tournaments = $tournamentRepository->findBy(['CreatorTournament' => $user]);
        return $tournaments;
    }
}
