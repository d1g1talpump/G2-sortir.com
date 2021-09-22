<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use http\Client\Curl\User;
use Monolog\Handler\Handler;
use phpDocumentor\Reflection\Types\Boolean;
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
        $eventsCurrentUser = null;

        if($this->getUser() != null){
            $eventsCurrentUser = $this->getUser()->getEvent();
        }

        return $this->render('main/home.html.twig', [
            "allEvents" => $allEvents,
            "eventsCurrentUser" => $eventsCurrentUser,
        ]);
    }
}
