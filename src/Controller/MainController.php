<?php

namespace App\Controller;

use App\Repository\EventRepository;
use http\Client\Curl\User;
use Monolog\Handler\Handler;
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

    /**
    public function subscribe(EventRepository $eventRepository, HandleRequest $user, Event $event){
        $event = $this->addUSer($user);

        return $this->render('main/home.html.twig',[
            "event" => $event
        ]);
    }
     **/
}
