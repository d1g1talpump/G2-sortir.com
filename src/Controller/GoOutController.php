<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/go", name="goOut_")
 */


class GoOutController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     */
    public function addEvent(): Response
    {
        return $this->render('go_out/add.html.twig');
    }

    /**
     * @return Response
     * @Route("/details", name="details")
     */
    public function detailsEvent(): Response
    {
        return $this->render('go_out/details.html.twig');
    }
}
