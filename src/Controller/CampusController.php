<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    /**
     * @Route("/campus", name="campus_list")
     */
    public function list(CampusRepository $campusRepository): Response
    {
        $allCampus = $campusRepository->findAll();

        return $this->render('campus/list.html.twig', [
            "allCampus" => $allCampus
        ]);
    }
}