<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

    #[Route('/ajax/create/section', name: 'app_ajax_section_create', methods: ['POST'])]
    public function createSection(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        return new JsonResponse(200);
    }

    #[Route('/ajax/delete/post/{id}', name: 'app_ajax_delete_post')]
    public function deletePost(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            return new JsonResponse(200);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }
}