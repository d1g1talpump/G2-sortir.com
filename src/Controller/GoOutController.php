<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\User;
use App\Entity\Event;
use App\Form\CancelEventFormType;
use App\Form\EventFormType;
use App\Repository\EventRepository;

use App\Repository\StatusRepository;
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
     * @Route ("/add", name="add")
     */
    public function manageEvent(
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

        return $this->render('go_out/manage.html.twig', [
            'eventForm' => $eventForm->createView(),
            'add' => true,
            'campus' => $user->getCampus(),
        ]);
    }

    /**
     * @Route ("/modify/{id}", name="modify")
     */
    public function modifyEvent(
        int                    $id,
        Request                $request,
        EntityManagerInterface $entityManager,
        EventRepository        $eventRepository,
        SwearWordCensor        $swearWordCensor
    ): Response
    {
        $event = $eventRepository->find($id);

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

        return $this->render('go_out/manage.html.twig', [
            'eventForm' => $eventForm->createView(),
            'add' => false,
        ]);
    }


    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsEvent(
        int             $id,
        EventRepository $eventRepository
    ): Response
    {
        $event = $eventRepository->find($id);

        return $this->render('go_out/details.html.twig', [
            "event" => $event
        ]);
    }

    /**
     * @Route ("/participate_event/{id}", name="participate")
     */
    public function participateEvent(
        int                    $id,
        EventRepository        $eventRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $event = $eventRepository->find($id);
        $currentUser = $this->getUser();

        $currentUser->subscribeEvent($event);

        $entityManager->flush();

        return $this->render('go_out/details.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route ("/leave_event/{id}", name="leave")
     */
    public function leaveEvent(
        int                    $id,
        EventRepository        $eventRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $event = $eventRepository->find($id);
        $currentUser = $this->getUser();

        $currentUser->unsubscribeEvent($event);

        $entityManager->flush();

        return $this->render('go_out/details.html.twig', [
            'event' => $event,
        ]);
    }


    /**
     * @Route ("/cancel/{id}", name="cancel")
     */
    public function deleteEvent(
        Request                $request,
        int                    $id,
        StatusRepository       $statusRepository,
        EventRepository        $eventRepository,
        EntityManagerInterface $entityManager
    ): Response
    {
        $event = $eventRepository->find($id);
        $event->setInfos('');

        $eventForm = $this->createForm(CancelEventFormType::class, $event);

        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            if ($eventForm->get("cancelEvent")->isClicked()) {
                $cancelState = $statusRepository->find(6);
                $event->setStatus($cancelState);
            }

            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event canceled !');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('go_out/cancel.html.twig', [
            'cancelEventForm' => $eventForm->createView(),
            'event' => $event
        ]);
    }
}
