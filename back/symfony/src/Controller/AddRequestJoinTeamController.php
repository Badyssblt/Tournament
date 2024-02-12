<?php

namespace App\Controller;

use App\Entity\TeamJoinRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddRequestJoinTeamController extends AbstractController
{
    public function __invoke(Security $security, Request $request, SerializerInterface $serializer)
    {
        $user = $security->getUser();
        if (!$user) {
            return $this->json(['message' => 'Veuillez vous connecter'], Response::HTTP_UNAUTHORIZED);
        }

        $targetUser = $serializer->deserialize($request->getContent(), TeamJoinRequest::class, "json");
        if ($user === $targetUser->getRequestingUser()) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        return $targetUser;
    }
}
