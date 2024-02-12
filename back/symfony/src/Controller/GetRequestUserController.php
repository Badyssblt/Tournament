<?php

namespace App\Controller;

use App\Repository\TeamJoinRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetRequestUserController extends AbstractController
{
    public function __invoke(Security $security, TeamJoinRequestRepository $teamJoinRequestRepository)
    {
        $user = $security->getUser();
        if (!$user) {
            return $this->json(['message' => 'Veuillez vous connecter'], Response::HTTP_UNAUTHORIZED);
        }

        $teamRequests = $teamJoinRequestRepository->findBy(['requestingUser' => $user]);
        $userData = [];
        foreach ($teamRequests as $teamRequest) {
            $userId = $teamRequest->getRequestingUser()->getId();
            $teamRequestId = $teamRequest->getId();
            $teamId = $teamRequest->getTargetTeam()->getId();
            $userName = $teamRequest->getTargetTeam()->getName();
            $userData[] = [
                'id' => $teamRequestId,
                'name' => $userName,
                'teamId' => $teamId
            ];
        }
        return $this->json($userData);
    }
}
