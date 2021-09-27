<?php

namespace App\Services;

use App\Entity\User;
use App\Security\AppAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserFormTreatment extends AbstractController
{

    public function treatment(
        User                         $user,
        UserPasswordEncoderInterface $passwordEncoder,
        FormInterface                $form,
        GuardAuthenticatorHandler    $guardHandler,
        Request                      $request,
        AppAuthenticator             $authenticator
    ): Response
    {
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $form->get('password')->getData()
            )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        // do anything else you need here, like send an email

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );
    }
}