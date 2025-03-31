<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    #[Route('/create_user', name: 'app_user_create')]
    public function createUser() : Response {
        return $this->render("/admin/user_form.html.twig");
    }

    #[Route('/ajax/profile', name: 'app_ajax_profile')]
    public function getProfile(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            $user = [
                'name' => 'Giuliana FABRIZIO',
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
                'name' => 'Giuliana FABRIZIO',
                'address' => '2 rue Sainte-Victoire, 13006 Marseille',
                'mail' => 'giuliana.godail-fabrizio@utbm.fr',
                'phone' => '0744564213',
                'password' => '123456789',
                'avatar' => 'cat'
            ];

            $data = json_decode($request->getContent(), true);

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