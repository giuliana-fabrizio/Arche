<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;
use App\Entity\Section;
use App\Repository\PostRepository;
use App\Repository\PostTypeRepository;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController {

    public function __construct(
        private PostRepository $postRepository,
        private PostTypeRepository $postTypeRepository,
        private SectionRepository $sectionRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    private function updatePostsRanking(Section $section, Int $id_post, Int $start_ranking, Int $stop_ranking) {
        $posts = $this->postRepository->getPostsToUpdateRanking(
            $section,
            $id_post,
            $start_ranking,
            $stop_ranking
        );

        $posts_to_update = [];

        foreach ($posts as $post) {
            $ranking = $post->getRanking();
            $post->setRanking(($start_ranking < $stop_ranking) ? $ranking - 1 : $ranking + 1);
            $posts_to_update[] = ['id' => $post->getId(), 'ranking' => $post->getRanking()];
        }

        $this->entityManager->flush();

        return $posts_to_update;
    }


    #[Route('/teacher/ajax/posts/{id}', name: 'app_ajax_get_posts', methods: ['GET'])]
    public function getSectionPosts(Request $request, Section $section) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $posts = $this->postRepository->getPostsOrdered($section);

        $data = array_map(function($post) {
            return [
                'id' => $post->getId(),
                'label' => $post->getLabel(),
            ];
        }, $posts);

        return new JsonResponse([
            'code' => 200,
            'posts' => $data
        ]);
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
    public function createPost(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $section = $this->sectionRepository->find($data['id_section']);

        $post = new Post();
        $post->setLabel($data['id_title'])
            ->setDescription($data['id_description'])
            ->setDatetime(new \DateTime())
            ->setFkUser($this->getUser())
            ->setFkSection($section);

        // TODO pinned

        if (!empty($data['id_type'])) {
            $postType = $this->postTypeRepository->find($data['id_type']);
            $post->setFkPostType($postType);
        }

        $count_posts = $this->postRepository->countPosts($section);
        $posts_to_update = [];

        if (!empty($data['id_classement'])) {
            $posts_to_update = $this->updatePostsRanking(
                $section,
                0,
                $count_posts + 1,
                (int) $data['id_classement']
            );
            $post->setRanking((int) $data['id_classement']);
        } else {
            $post->setRanking($count_posts + 1);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $html = null;

        if ($post->getFkPostType()) {
            $html = $this->renderView('home/_post.html.twig', [
                'id_ue' => $section->getFkUe()->getId(),
                'id_section' => $section->getId(),
                'post' => $post
            ]);
        }

        usort($posts_to_update, function($a, $b) {
            return $a['ranking'] <=> $b['ranking'];
        });

        return new JsonResponse([
            'code' => 200,
            'html' => $html,
            'id_post' => $post->getId(),
            'post_ranking' => $post->getRanking(),
            'posts_to_update' => $posts_to_update
        ]);
    }


    #[Route('/teacher/ajax/edit/post/{id}', name: 'app_ajax_post_edit', methods: ['PUT'])]
    public function editUe(Request $request, Post $post) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $section = $this->sectionRepository->find($data['id_section']);

        $post->setLabel($data['id_title'])
            ->setDescription($data['id_description'])
            ->setFkSection($section);

        // TODO pinned

        if (!empty($data['id_type'])) {
            $postType = $this->postTypeRepository->find($data['id_type']);
            $post->setFkPostType($postType);
        }

        $posts_to_update = [];

        if (!empty($data['id_classement'])) {
            $posts_to_update = $this->updatePostsRanking(
                $section,
                $post->getId(),
                $post->getRanking(),
                (int) $data['id_classement']
            );
            $post->setRanking((int) $data['id_classement']);
        }

        $this->entityManager->flush();

        $html = null;

        if ($post->getFkPostType()) {
            $html = $this->renderView('home/_post.html.twig', [
                'id_ue' => $section->getFkUe()->getId(),
                'id_section' => $section->getId(),
                'post' => $post
            ]);
        }

        usort($posts_to_update, function($a, $b) {
            return $a['ranking'] <=> $b['ranking'];
        });

        return new JsonResponse([
            'code' => 200,
            'html' => $html,
            'post_ranking' => $post->getRanking(),
            'posts_to_update' => $posts_to_update
        ]);
    }


    #[Route('/teacher/ajax/update/post_file/{id}', name: 'app_ajax_edit_post_file', methods: ['POST'])]
    public function updatePostFile(Request $request, Post $post) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $file = $request->files->get('file');

        $extension = $file->guessExtension() ?: 'bin';
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = $filename."_".$post->getDateTime()->format('d-m-Y_H-i-s').".".$extension;

        $uploadDir = $this->getParameter('kernel.project_dir').'/public/files';

        $file->move($uploadDir, $filename);

        $post->setFilename($filename);
        $post->setFiletype($extension);

        $this->entityManager->flush();

        $html = $this->renderView('home/_post.html.twig', [
            'id_ue' => $post->getFkSection()->getFkUe()->getId(),
            'id_section' => $post->getFkSection()->getId(),
            'post' => $post
        ]);

        return new JsonResponse([
            'code' => 200,
            'html' => $html,
            'id_post' => $post->getId(),
            'post_ranking' => $post->getRanking()
        ]);
    }


    #[Route('/teacher/ajax/delete/post/{id}', name: 'app_ajax_delete_post', methods: ['DELETE'])]
    public function deletePost(Request $request, Post $post) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $count_posts = $this->postRepository->countPosts($post->getFkSection());

        $this->updatePostsRanking(
            $post->getFkSection(),
            $post->getId(),
            $post->getRanking(),
            $count_posts + 1
        );

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return new JsonResponse(200);
    }
}