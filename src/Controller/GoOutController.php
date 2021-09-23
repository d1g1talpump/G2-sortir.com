<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\User;
use App\Entity\Event;
use App\Form\EventFormType;

use App\Repository\EventRepository;

use App\Services\SwearWordCensor;

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
    public function addEvent(

        Request                $request,
        EntityManagerInterface $entityManager,
        SwearWordCensor        $swearWordCensor
    ): Response

    {
        $event = new Event();
        $status = new Status();

        $user = $this->getUser();
        $event->setOrganiser($user);
        $event->setCampus($user->getCampus());

        $eventForm = $this->createForm(EventFormType::class, $event);

        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            if ($eventForm->get("createEvent")->isClicked()) {
                $status = $entityManager->find(Status::class, 1);
            } elseif ($eventForm->get("publishEvent")->isClicked()) {
                $status = $entityManager->find(Status::class, 2);
            }
            $event->setStatus($status);

            $purifyString = $swearWordCensor->purify($event->getName());
            $event->setName($purifyString);
            $purifyString = $swearWordCensor->purify($event->getInfos());
            $event->setInfos($purifyString);

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
     * @Route("/details/{id}", name="details")
     */
    public function detailsEvent(
        int                    $id,
        EventRepository        $eventRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $event = $eventRepository->find($id);
        $currentUser = $this->getUser();

        $currentUser->addEvent($event);
        $event->addUser($currentUser);

        $entityManager->persist($event);
        $entityManager->flush();

        return $this->render('go_out/details.html.twig', [
            'event' => $event,
        ]);
    }

}
