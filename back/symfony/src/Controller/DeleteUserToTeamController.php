<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class DeleteUserToTeamController extends AbstractController
{
    public function __invoke(int $id, Security $security, EntityManagerInterface $manager, TeamRepository $teamRepository, SerializerInterface $serializer, Request $request)
    {
        if (!$security->getUser()) {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }
        $user = $security->getUser();
        $team = $teamRepository->find($id);
        $content = $request->getContent();
        $data = $serializer->deserialize($content, Team::class, "json");
        $deleteUser = $data->getUser()[0];
        if ($team->isCreator($user)) {
            $team->removeUser($deleteUser);
            $manager->persist($team);
            $manager->flush();
            return $team;
        } else {
            return $this->json(null, Response::HTTP_UNAUTHORIZED);
        }
    }
}
