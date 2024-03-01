<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCollectionTournamentController extends AbstractController
{
    public function __invoke(TournamentRepository $tournamentRepository)
    {
        $tournaments = $tournamentRepository->findBy(['visibility' => true]);
        return $tournaments;
    }
}
