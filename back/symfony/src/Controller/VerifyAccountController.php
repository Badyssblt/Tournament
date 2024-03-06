<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerifyAccountController extends AbstractController
{
    public function __invoke(Security $security, UserRepository $repository, int $id, int $code, EntityManagerInterface $manager)
    {
        $user = $repository->find($id);
        $userCode = $user->getVerificationCode();
        if ($userCode !== $code) {
            return $this->json(['message' => 'Les codes de vérifications ne correspondent pas.'], Response::HTTP_UNAUTHORIZED);
        }

        $user->setIsVerified(true);
        $manager->persist($user);
        $manager->flush();
        return $user;
    }
}
