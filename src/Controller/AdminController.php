<?php

namespace App\Controller;

use App\Repository\UserRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route ("/de")
     */
}
