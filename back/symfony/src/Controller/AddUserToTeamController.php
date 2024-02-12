<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AddUserToTeamController extends AbstractController
{
    public function __invoke(string $id, EntityManagerInterface $manager, Request $request, SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);
        $userUri = $data['user'][0] ?? null;
        $userId = basename($userUri);
        $user = $manager->find(User::class, $userId);
        if ($user) {
            $team = $manager->find(Team::class, $id);
            if ($user)
                if ($team) {
                    $users = $team->getUser();
                    $users->initialize();
                    if (!$users->contains($user)) {
                        $team->addUser($user);
                        $manager->flush();
                        return $team;
                    } else {
                        return $team;
                    }
                } else {
                    return $team;
                }
        }
    }
}
