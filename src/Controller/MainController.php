<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
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
    public function home(EventRepository $eventRepository): Response
    {
        $allEvents = $eventRepository->findAll();
        $eventsCurrentUser = null;

        //Get all events subscribed by current user
        if($this->getUser() != null){
            $eventsCurrentUser = $this->getUser()->getEvent();
        }

        $user = $this->getUser();
        dump($user);

        return $this->render('main/home.html.twig', [
            "allEvents" => $allEvents,
            "eventsCurrentUser" => $eventsCurrentUser,
        ]);
    }
}
