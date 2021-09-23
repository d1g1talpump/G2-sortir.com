<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */

    public function home(
        EventRepository $eventRepository
    ): Response
    {
        $allEvents = $eventRepository->allEventsHomePage();
        dump($allEvents);

          
        return $this->render('main/home.html.twig', ["allEvents" => $allEvents]);
    }
}
