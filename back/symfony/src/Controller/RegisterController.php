<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RegisterController extends AbstractController
{
    public function __invoke(Request $request, SerializerInterface $serializer, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager)
    {
        $user = $serializer->deserialize($request->getContent(), User::class, "json");
        $plainPassword = $user->getPassword();
        $hashedPassword = $hasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        return $user;
    }
}
