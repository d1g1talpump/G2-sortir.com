<?php

namespace App\Controller;

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
        $user = $this->getUser();

        $event->setOrganiser($user);
        $event->setCampus($user->getCampus());

        $eventForm = $this->createForm(EventFormType::class, $event);

        $eventForm->handleRequest($request);

        if($eventForm->isSubmitted() && $eventForm->isValid()){

            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event added !');
            //TODO return $this->redirectToRoute('');
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
