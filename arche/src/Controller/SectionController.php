<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Section;
use App\Repository\UeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController {

    public function __construct(
        private readonly UeRepository $ueRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/teacher/ajax/create/section', name: 'app_ajax_section_create', methods: ['POST'])]
    public function createSection(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);
        $ue = $this->ueRepository->find($data['ue_id']);

        $section = new Section();
        $section->setLabel($data['label']);
        $section->setFkUe($ue);

        if (!empty($data['classement'])) {
            $section->setRanking($data['classement']);
        }

        $this->entityManager->persist($section);
        $this->entityManager->flush();

        $html = $this->renderView('home/_section.html.twig', [
            'section' => $section,
            'isCollapse' => false
        ]);

        return new JsonResponse([
            'code' => 200,
            'html' => $html,
            'section_id' => $section->getId(),
            'section_label' => $section->getLabel()
        ]);
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