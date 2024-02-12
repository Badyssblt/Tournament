<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FindUserByEmailController extends AbstractController
{
    public function __invoke(Security $security, UserRepository $userRepository, string $email)
    {
        $user = $security->getUser();
        if(!$user){
            return $this->json(['message' => 'Veuillez vous connectez'], Response::HTTP_UNAUTHORIZED);
        }


        $user = $userRepository->findOneBy(['email' => $email]);
        $user->setPassword("");
        if($user){
            return $this->json($user);
        }
    }
}
