<?php

namespace App\Controller;


use App\Repository\EventRepository;

use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\AutoUpdateEventStatus;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(
        EventRepository $eventRepository,
        StatusRepository $statusRepository,
        EntityManagerInterface $entityManager,
        AutoUpdateEventStatus $autoUpdateEventStatus
    ): Response
    {

        $allEvents = $eventRepository->allEventsForHomePage();

        $subsPerEvent = $this->getSubsPerEvent($allEvents);

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
