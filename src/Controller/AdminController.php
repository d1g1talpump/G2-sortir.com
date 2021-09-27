<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeUserPrivilagesType;
use App\Form\ManageProfileFormType;
use App\Form\TestChangeUserPrivilegesType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use App\Services\UserFormTreatment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @Route ("", name="dashboard")
     */
    public function dashboard(
        UserRepository $userRepository
    ): Response
    {
        $allUsers = $userRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'allUsers' => $allUsers
        ]);
    }

    /**
     * @Route ("/adduser", name="add_user")
     */
    public function addUser(
        Request                      $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler    $guardHandler,
        AppAuthenticator             $authenticator,
        UserFormTreatment            $formTreatment
    ): Response
    {
        $user = new User();
        $user->setAdmin(false)
            ->setActive(true)
            ->setRoles(["ROLE_USER"]);

        $form = $this->createForm(ManageProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $formTreatment->treatment($user, $passwordEncoder, $form, $guardHandler, $request, $authenticator);
        }

        return $this->render('profile/manage.html.twig', [
            'manageProfileForm' => $form->createView(),
        ]);
    }


    /**
     * @Route ("/managePrivileges/{id}", name="managePrivileges")
     */

    public function managePrivileges(
        Request                $request,
        int                    $id,
        UserRepository         $userRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $userRepository->find($id);

        $managePrivilegesForm = $this->createForm(ChangeUserPrivilagesType::class, $user);

        $managePrivilegesForm->handleRequest($request);

        if ($managePrivilegesForm->isSubmitted() && $managePrivilegesForm->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'User Updated !');
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('profile/viewProfile.html.twig', [
            'updateUserPrivilegesForm' => $managePrivilegesForm->createView(),
            'selectedUser' => $user
        ]);
    }

}
