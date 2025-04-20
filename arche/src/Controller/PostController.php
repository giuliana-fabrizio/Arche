<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use App\Repository\PostTypeRepository;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

    public function __construct(
        private PostTypeRepository $postTypeRepository,
        private SectionRepository $sectionRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/teacher/ajax/post_type', name: 'app_ajax_get_post_type', methods: ['GET'])]
    public function getPostType(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $postTypes = $this->postTypeRepository->findAll();

        $data = array_map(function($type) {
            return [
                'id' => $type->getId(),
                'label' => $type->getLabel(),
            ];
        }, $postTypes);

        return new JsonResponse([
            'code' => 200,
            'post_type' => $data
        ]);
    }


#[Route('/teacher/ajax/create/post', name: 'app_ajax_post_create', methods: ['POST'])]
    public function createUe(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $section = $this->sectionRepository->find($data['id_section']);

        $post = new Post();
        $post = (new Post())
            ->setLabel($data['id_title'])
            ->setDescription($data['id_description'])
            ->setDatetime(new \DateTime())
            ->setFkUser($this->getUser())
            ->setFkSection($section);

        // TODO pinned

        if (!empty($data['id_type'])) {
            $postType = $this->postTypeRepository->find($data['id_type']);
            $post->setFkPostType($postType);
        } else {
            // TODO upload ici :)
        }

        if (isset($data['id_classement']) && is_numeric($data['id_classement'])) {
            $post->setRanking((int) $data['id_classement']);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $html = $this->renderView('home/_post.html.twig', [
            'id_section' => $section->getId(),
            'post' => $post
        ]);

        return new JsonResponse(['code' => 200, 'html' => $html]);
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