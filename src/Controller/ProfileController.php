<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ManageProfileFormType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/profile", name="profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/manage", name="manage")
     */
    public function manage(
        Request                      $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler    $guardHandler,
        AppAuthenticator             $authenticator,
        UserRepository               $userRepository
    ): Response
    {

        if ($this->getUser()) {
            $user = $userRepository->find($this->getUser()->getId());
        } else {
            $user = new User();
            $user->setAdmin(false)
                ->setActive(true)
                ->setRoles(["ROLE_USER"]);
        }

        $form = $this->createForm(ManageProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

        return $this->render('profile/manage.html.twig', [
            'manageProfileForm' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/view/{id}", name="view")
     */
    public function viewProfile(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        return $this->render('profile/viewProfile.html.twig', [
            'selectedUser' => $user,
        ]);
    }
}
