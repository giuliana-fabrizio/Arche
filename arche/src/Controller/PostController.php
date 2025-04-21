<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/teacher/create_post', name: 'app_post_create')]
    public function createUe() : Response {
        return $this->render("/teacher/post_form.html.twig");
    }


    #[Route('/teacher/ajax/delete/post/{id}', name: 'app_ajax_delete_post', methods: ['DELETE'])]
    public function deletePost(Request $request, Post $post) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return new JsonResponse(200);
    }
}