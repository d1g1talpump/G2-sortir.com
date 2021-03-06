<?php

namespace App\Controller\API;

use App\Repository\CampusRepository;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiFiltreController extends AbstractController
{
    /**
     *
     * @Route("/api/campus", name="api_filtre_campus", methods={"GET"})
     * @param CampusRepository $campusRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function filtreCampus(
                                CampusRepository $campusRepository,
                                EventRepository $eventRepository,
                                SerializerInterface $serializer,
                                Request $request){

        // get the name query
        $campus = $campusRepository->findByName();

        //if twig
        if($request->query->get('option', 'json') == 'twig'){
            //twig
            $html = $this->renderView('inc/_select.html.twig', [
                'campusNames' => $campus
            ]);
            return new Response($html);
        }
        // if json
        else{

            //convertir en json
            //$json = json_encode();
            $json = $serializer->serialize($campus, 'json', ['groups'=>"campusNames"]);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

    }

    public function searchButton(EventRepository $eventRepository,
                                CampusRepository $campusRepository,
                                Request $request,
                                SerializerInterface $serializer){
        $searchByCampus = $eventRepository->findByCampusNames();

        $json = $serializer->serialize($searchByCampus, 'json', ['groups'=>"campusNames"]);
        return new JsonResponse($json, Response::HTTP_OK, [], true);

    }
}