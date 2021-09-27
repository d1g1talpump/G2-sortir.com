<?php

namespace App\Controller\API;

use App\Repository\CampusRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiFiltreController extends AbstractController
{
    /**
     * @Route("/api/campus", name="api_filtre_campus", methods={"GET"})
     * @param CampusRepository $campusRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function filtreCampus(
                                CampusRepository $campusRepository,
                                SerializerInterface $serializer,
                                Request $request){


        $campus = $campusRepository->findByName();

        if($request->query->get('option', 'json') == 'twig'){
            //twig
            $html = $this->renderView('inc/_select.html.twig', [
                'campusNames' => $campus
            ]);
            return new Response($html);
        }
        else{
            //json
            //convertir en json
            //$json = json_encode();
            $json = $serializer->serialize($campus, 'json', ['groups'=>"campusNames"]);
            return new JsonResponse($json, Response::HTTP_OK, [], true);
        }

    }
}