<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\User;
use App\Entity\Event;
use App\Form\EventFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function addEvent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $status = new Status();

        $user = $this->getUser();
        $event->setOrganiser($user);
        $event->setCampus($user->getCampus());

        $eventForm = $this->createForm(EventFormType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){
            if($eventForm->get("createEvent")->isClicked()){
                $status = $entityManager->find(Status::class, 1);
            }
            elseif ($eventForm->get("publishEvent")->isClicked()){
                $status = $entityManager->find(Status::class, 2);
            }
            $event->setStatus($status);
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event added !');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('go_out/add.html.twig', [
            'eventForm' => $eventForm->createView(),
            'campus' => $user->getCampus(),
        ]);
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
