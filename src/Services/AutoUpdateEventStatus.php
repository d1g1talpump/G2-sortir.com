<?php

namespace App\Services;

use App\Entity\Status;
use App\Repository\EventRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AutoUpdateEventStatus
{

    public function setSubscriptionsEnded(
        EventRepository        $eventRepository,
        StatusRepository       $statusRepository,
        EntityManagerInterface $entityManager
    ): void
    {
        $eventsJustStarted = $eventRepository->getEventsJustEnded();
        $statusJustStarted = $statusRepository->find(3);

        $this->forEachEventSetStatusAndSendToDB($eventsJustStarted, $statusJustStarted, $entityManager);
    }

    public function setEventsInProgress(
        EventRepository        $eventRepository,
        StatusRepository       $statusRepository,
        EntityManagerInterface $entityManager
    ): void
    {
        $eventsJustStarted = $eventRepository->getEventsJustStarted();
        $statusJustStarted = $statusRepository->find(4);

        $this->forEachEventSetStatusAndSendToDB($eventsJustStarted, $statusJustStarted, $entityManager);
    }

    public function setEventsEnded(
        EventRepository        $eventRepository,
        StatusRepository       $statusRepository,
        EntityManagerInterface $entityManager
    ): void
    {
        $eventsJustStarted = $eventRepository->getEventsJustEnded();
        $statusJustStarted = $statusRepository->find(5);

        $this->forEachEventSetStatusAndSendToDB($eventsJustStarted, $statusJustStarted, $entityManager);
    }

    public function setEventsToHide(
        EventRepository        $eventRepository,
        StatusRepository       $statusRepository,
        EntityManagerInterface $entityManager)
    {
        $eventsJustStarted = $eventRepository->getEventsToHide();
        $statusJustStarted = $statusRepository->find(7);

        $this->forEachEventSetStatusAndSendToDB($eventsJustStarted, $statusJustStarted, $entityManager);
    }


    public function forEachEventSetStatusAndSendToDB(
        Paginator $eventsJustStarted,
        Status $statusJustStarted,
        EntityManagerInterface $entityManager): void
    {
        foreach ($eventsJustStarted as $event) {
            $event->setStatus($statusJustStarted);
            $entityManager->persist($event);
        }
        $entityManager->flush();
    }
}