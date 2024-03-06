<?php

namespace App\EventListener;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationSuccessListener
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $user = $event->getUser();
        $response = $event->getResponse();
        if ($user instanceof UserInterface) {
            if ($user instanceof User && !$user->getIsVerified()) {
                $data = ["userId" => $user->getId(), "message" => 'Votre compte n\'est pas vérifié.'];
                $event->setData($data);

                $response->setContent(json_encode($data));
                $response->setStatusCode(JsonResponse::HTTP_UNAUTHORIZED);
            }
        }
    }
}
