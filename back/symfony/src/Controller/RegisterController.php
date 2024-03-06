<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RegisterController extends AbstractController
{
    public function __invoke(MailerInterface $mailer, Request $request, SerializerInterface $serializer, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager)
    {
        $user = $serializer->deserialize($request->getContent(), User::class, "json");
        $plainPassword = $user->getPassword();
        $hashedPassword = $hasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        $code = rand(10000, 99999);
        $user->setVerificationCode($code);
        $html = "<h1>Merci d'avoir créer un compte sur <b>Scoped !</b></h1><br><br><p>Vérifier votre compte avec le code : <b>" . $code . "</b></p>";
        $email = (new Email())
            ->from('scopedtournament@gmail.com')
            ->to($user->getEmail())
            ->subject('Confirmation de création de compte')
            ->html($html);
        $mailer->send($email);
        $manager->persist($user);
        $manager->flush();
        $safeUserData = clone $user;
        $safeUserData->setPassword('');
        $safeUserData->setVerificationCode(0);
        return $this->json($safeUserData, 200);
    }
}
