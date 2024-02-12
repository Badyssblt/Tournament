<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TeamJoinRequest;
use App\Entity\User;
use App\Repository\TeamJoinRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AcceptToJoinTeamController extends AbstractController
{
    public function __invoke(Request $request, int $id, Security $security, SerializerInterface $serializer, TeamJoinRequestRepository $repository, EntityManagerInterface $manager)
    {
        $content = $request->getContent();
        $user = $security->getUser();
        if (!$user) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }

        $requestData = $serializer->deserialize($content, TeamJoinRequest::class, 'json');
        $requestData->setId($id);
        $existingRequest = $repository->find($id);
        if ($existingRequest !== null && $existingRequest->getRequestingUser() === $user && $existingRequest->getTargetTeam() === $requestData->getTargetTeam()) {
            $team = $existingRequest->getTargetTeam();
            if ($requestData->getStatus() === "accept") {
                $team->addUser($user);
                $manager->persist($team);
                $manager->flush();
                $existingRequest->setStatus("accept");
                $manager->remove($existingRequest);
                $manager->flush();
                return $team;
            } else if ($requestData->getStatus() === "denied") {
                $manager->remove($existingRequest);
                $manager->flush();
                return $this->json(null, Response::HTTP_NO_CONTENT);
            }
        } else {
            return $this->json(null, Response::HTTP_NO_CONTENT);
        }
    }
}
