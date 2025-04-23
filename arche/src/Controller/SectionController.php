<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Section;
use App\Entity\Ue;
use App\Repository\SectionRepository;
use App\Repository\UeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController {

    public function __construct(
        private readonly SectionRepository $sectionRepository,
        private readonly UeRepository $ueRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    private function updateSectionsRanking(Ue $ue, Int $id_section, Int $start_ranking, Int $stop_ranking) {
        $sections = $this->sectionRepository->getSectionsToUpdateRanking(
            $ue,
            $id_section,
            $start_ranking,
            $stop_ranking
        );

        $sections_to_update = [];

        foreach ($sections as $section) {
            $ranking = $section->getRanking();
            $section->setRanking(($start_ranking < $stop_ranking) ? $ranking - 1 : $ranking + 1);
            $sections_to_update[] = ['id' => $section->getId(), 'ranking' => $section->getRanking()];
        }

        $this->entityManager->flush();

        return $sections_to_update;
    }


    #[Route('/teacher/ajax/sections/{id}', name: 'app_ajax_get_sections', methods: ['GET'])]
    public function getSectionsWithPostsOrdered(Request $request, Ue $ue) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $sections = $this->sectionRepository->getSectionsWithPostsOrdered($ue);

        $data = array_map(function($section) {
            return [
                'id' => $section->getId(),
                'label' => $section->getLabel(),
                'ranking' => $section->getRanking()
            ];
        }, $sections);

        return new JsonResponse([
            'code' => 200,
            'sections' => $data
        ]);
    }


    #[Route('/teacher/ajax/create/section', name: 'app_ajax_section_create', methods: ['POST'])]
    public function createSection(Request $request) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true); // On récupère les données transmises (section ici) par Ajax dans le BODY
        $ue = $this->ueRepository->find($data['id_ue']);

        $section = (new Section())
            ->setLabel($data['label'])
            ->setFkUe($ue)
            ->setFkUser($this->getUser());

        if (!empty($data['classement'])) {
            $section->setRanking((int) $data['classement']);
        }

        $count_sections = $this->sectionRepository->countSections($section->getFkUe());
        $sections_to_update = [];

        if (!empty($data['classement'])) {
            $sections_to_update = $this->updateSectionsRanking(
                $section->getFkUe(),
                0,
                $count_sections + 1,
                (int) $data['classement']
            );
            $section->setRanking((int) $data['classement']);
        } else {
            $section->setRanking($count_sections + 1);
        }

        $this->entityManager->persist($section);
        $this->entityManager->flush();

        $html = $this->renderView('home/_section.html.twig', [
            'id_ue' => $ue->getId(),
            'section' => $section,
            'isCollapse' => false
        ]);

        usort($sections_to_update, function($a, $b) {
            return $a['ranking'] <=> $b['ranking'];
        });

        return new JsonResponse([
            'code' => 200,
            'html' => $html,
            'section_id' => $section->getId(),
            'section_label' => $section->getLabel(),
            'section_ranking' => $section->getRanking(),
            'sections_to_update' => $sections_to_update
        ]);
    }


    #[Route('/teacher/ajax/edit/section/{id}', name: 'app_ajax_section_edit', methods: ['PUT'])]
    public function editSection(Request $request, Section $section) : Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($request->getContent(), true);

        $section->setLabel($data['label']);

        $sections_to_update = [];

        if (!empty($data['classement']) && $data['classement'] != $section->getRanking()) {
            $sections_to_update = $this->updateSectionsRanking(
                $section->getFkUe(),
                $section->getId(),
                $section->getRanking(),
                (int) $data['classement']
            );
            $section->setRanking((int) $data['classement']);
        }

        $this->entityManager->flush();

        usort($sections_to_update, function($a, $b) {
            return $a['ranking'] <=> $b['ranking'];
        });

        return new JsonResponse([
            'code' => 200,
            'id_ue' => $section->getFkUe()->getId(),
            'section_label' => $section->getLabel(),
            'section_ranking' => $section->getRanking(),
            'sections_to_update' => $sections_to_update
        ]);
    }


    #[Route('/teacher/ajax/delete/section/{id}', name: 'app_ajax_delete_section', methods: ['DELETE'])]
    public function deleteSection(Request $request, Section $section): Response {
        if(!$request->isXmlHttpRequest()) {
            return new JsonResponse(['error' => 'Cet appel doit être effectué via AJAX.'], Response::HTTP_BAD_REQUEST);
        }

        $count_sections = $this->sectionRepository->countSections($section->getFkUe());

        $this->updateSectionsRanking(
            $section->getFkUe(),
            $section->getId(),
            $section->getRanking(),
            $count_sections + 1
        );

        $this->entityManager->remove($section);
        $this->entityManager->flush();

        return new JsonResponse(200);
    }
}