<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Section;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController {

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/teacher/ajax/create/section', name: 'app_ajax_section_create', methods: ['POST'])]
    public function createSection(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        $html = $this->renderView('home/_section.html.twig', [
            'section' => $data,
        ]);

        return new JsonResponse([ 'code' => 200, 'html' => $html ]);
    }


    #[Route('/teacher/ajax/delete/section/{id}', name: 'app_ajax_delete_section', methods: ['DELETE'])]
    public function deleteSection(Request $request, Section $section): Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->remove($section);
        $this->entityManager->flush();

        return new JsonResponse(200);
    }
}