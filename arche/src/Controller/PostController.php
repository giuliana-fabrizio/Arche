<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use App\Repository\PostTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

    public function __construct(
        private PostTypeRepository $postTypeRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/teacher/ajax/create/post', name: 'app_ajax_post_create')]
    public function createUe() : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $ue = $this->ueRepository->find($data['id_ue']);

        $post = new Post();
        $post->setDatatime(new DateTime());
        $post->setDescription($data['description']);
        $post->setLabel($data['title']);

        $section = $this->sectionRepository->find($data['id_section']);
        $post->setFkSection($section);

        // TODO pinned

        if (!empty($data['type'])) {
            $post_type = $this->postTypeRepository->find($data['type']);
            $post->setFkPostType($post_type);
        } else {
            $post->setFilename($data['filename']);
            $filetype = "doc"; // TODO regex pour récupérer l'extension du fichier
            $post->setFiletype($filetype);
        }

        if (!empty($data['classement'])) {
            $section->setRanking($data['classement']);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $this->render("/teacher/post_form.html.twig");
    }


    #[Route('/teacher/ajax/delete/post/{id}', name: 'app_ajax_delete_post')]
    public function deletePost(Request $request) : Response {
        if($request->isXmlHttpRequest()) {
            return new JsonResponse(200);
        }
        return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
    }
}