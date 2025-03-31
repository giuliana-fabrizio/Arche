<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UeController extends AbstractController {

    #[Route('/create_ue', name: 'app_ue_create')]
    public function createUe() : Response {
        return $this->render("/admin/ue_form.html.twig");
    }


    #[Route('/ajax/delete/ue/{id}', name: 'app_ajax_delete_ue')]
    public function deleteUe(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            return new JsonResponse("Success");
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }


    #[Route('/choose_ue', name: 'app_ue_choose')]
    public function chooseUe() : Response {
        return $this->render("/home/home.html.twig");
    }


    #[Route('/', name: 'app_ue_content')] // TODO intégrer le code d'Amir
    public function getUe() : Response {
        return $this->render("/profile/catalogue.html.twig");
    }
}