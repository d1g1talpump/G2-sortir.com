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
//        $allEvents = $eventRepository->allEventsForHomePage();
        $allEvents = $eventRepository->findAll();
        $eventsCurrentUser = null;

        //Get all events subscribed by current user
        if($this->getUser() != null){
            $eventsCurrentUser = $this->getUser()->getEvent();
        }


        dump($this->getUser());
        dump($eventsCurrentUser);
        return $this->render('main/home.html.twig', [
            "allEvents" => $allEvents,
            "eventsCurrentUser" => $eventsCurrentUser,
        ]);

    }
}
