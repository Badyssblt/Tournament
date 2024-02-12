<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTournamentMatcheController extends AbstractController
{
    public function __invoke(int $id, TournamentRepository $tournamentRepository)
    {
        $tournament = $tournamentRepository->find($id);
        dd($tournament);
    }
}
