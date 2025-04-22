<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }


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


    #[Route('/ajax/profile', name: 'app_ajax_get_profile')]
    public function getProfile(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $currentUser = $this->getUser();

        $user = [
            'firstname' => $currentUser->getFirstname(),
            'name' => $currentUser->getLastname(),
            'address' => $currentUser->getAddress(),
            'mail' => $currentUser->getEmail(),
            'phone' => $currentUser->getPhone(),
            'password' => $currentUser->getPassword(),
            'avatar' => $currentUser->getAvatar()
        ];

        return new JsonResponse($user);
    }


    #[Route('/ajax/post/profile', name: 'app_ajax_post_profile', methods: ['POST'])]
    public function manageProfile(Request $request): Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $currentUser = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $currentUser->setFirstname($data['firstname']);
        $currentUser->setLastname($data['name']);
        $currentUser->setAddress($data['address']);
        $currentUser->setPhone($data['phone']);
        $currentUser->setPassword($data['password']);
        $currentUser->setAvatar($data['avatar']);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_ajax_get_profile');
    }
}