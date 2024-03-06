<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SearchTournamentController extends AbstractController
{
    public function __invoke(Request $request, TournamentRepository $tournamentRepository, SerializerInterface $serializer)
    {
        $category = $request->query->get('category');
        $name = $request->query->get('name');
        if ($category && $name) {
            $tournaments = $tournamentRepository->findByGameCategoryAndName($category, $name);
        } else if ($category && !$name) {
            $tournaments = $tournamentRepository->findByGameCategory($category);
        } else if (!$category && $name) {
            $tournaments = $tournamentRepository->findByName($name);
            dd($tournaments);
        }
        return $tournaments;
    }
}
