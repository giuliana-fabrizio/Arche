<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    #[Route('/admin/ajax/create/user', name: 'app_ajax_user_create', methods: ['POST'])]
    public function createUser(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        return new JsonResponse(200);
    }


    #[Route('/admin/ajax/edit/user', name: 'app_ajax_user_edit', methods: ['PUT'])]
    public function editUser(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        return new JsonResponse(200);
    }


    #[Route('/admin/ajax/delete/user/{id}', name: 'app_ajax_delete_user')]
    public function deleteUe(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            return new JsonResponse(200);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }


    #[Route('/ajax/profile', name: 'app_ajax_profile')]
    public function getProfile(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            $user = [
                'firstname' => 'Giuliana',
                'name' => 'FABRIZIO',
                'address' => '2 rue Sainte-Victoire, 13006 Marseille',
                'mail' => 'giuliana.godail-fabrizio@utbm.fr',
                'phone' => '0744564213',
                'password' => '123456789',
                'avatar' => 'cat'
            ];

            return new JsonResponse($user);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }


    #[Route('/ajax/post/profile', name: 'app_ajax_post_profile', methods: ['POST'])]
    public function manageProfile(Request $request): JsonResponse {
        if($request->isXmlHttpRequest()) {
            $user = [
                'firstname' => 'Giuliana',
                'name' => 'FABRIZIO',
                'address' => '2 rue Sainte-Victoire, 13006 Marseille',
                'mail' => 'giuliana.godail-fabrizio@utbm.fr',
                'phone' => '0744564213',
                'password' => '123456789',
                'avatar' => 'cat'
            ];

            $data = json_decode($request->getContent(), true);

            $user['firstname'] = $data['firstname'];
            $user['name'] = $data['name'];
            $user['address'] = $data['address'];
            $user['phone'] = $data['phone'];
            $user['password'] = $data['password'];
            $user['avatar'] = $data['avatar'];

            return new JsonResponse($user);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }
}