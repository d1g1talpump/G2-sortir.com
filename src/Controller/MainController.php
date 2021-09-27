<?php

namespace App\Controller;


use App\Repository\EventRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(EventRepository $eventRepository): Response
    {


        $allEvents = $eventRepository->allEventsForHomePage(); //TODO uncomment the condition in the query method when the fixture is fixed

        $subsPerEvent = $this->getSubsPerEvent($allEvents);

        $allEvents = $eventRepository->findAll();
        $eventsCurrentUser = null;


        //Get all events subscribed by current user
        $eventsCurrentUser = null;
        if ($this->getUser() != null) {
            $eventsCurrentUser = $this->getUser()->getEvent();
        }

        return $this->render('main/home.html.twig', [
            "allEvents" => $allEvents,
            "eventsCurrentUser" => $eventsCurrentUser,
            "subsPerEvent" => $subsPerEvent
        ]);

    }

    /**
     * @return array
     */
    public function getSubsPerEvent($allEvents): array
    {
        $i = 0;
        $subsPerEvent = [];
        foreach ($allEvents as $event) {
            $i++;
            $subCount = count($event->getUsers());
            array_push($subsPerEvent, [$i => $subCount]);
        }
        return $subsPerEvent;
    }
}
