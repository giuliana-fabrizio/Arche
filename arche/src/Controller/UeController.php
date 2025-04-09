<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UeController extends AbstractController {

    #[Route('/ajax/create/ue', name: 'app_ajax_ue_create', methods: ['POST'])]
    public function createUe(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        return new JsonResponse(200);
    }


    #[Route('/ajax/edit/ue', name: 'app_ajax_ue_edit', methods: ['PUT'])]
    public function editUe(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        return new JsonResponse(200);
    }


    #[Route('/ajax/delete/ue/{id}', name: 'app_ajax_delete_ue')]
    public function deleteUe(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            return new JsonResponse(200);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }


    #[Route('/choose_ue', name: 'app_ue_choose')]
    public function chooseUe() : Response {
        return $this->render("/home/home.html.twig");
    }


    #[Route('/', name: 'app_ue_content')]
    public function getUe() : Response {
        return $this->render("/profile/catalogue.html.twig");
    }
}