<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    public function __construct(
        private readonly UeRepository $ueRepository,
        private readonly UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {
    }


    #[Route('/', name: 'app_home')]
    public function home() : Response {
        if (
            $this->getUser()->getRoles()[0] == "ROLE_ADMIN" ||
            $this->getUser()->getRoles()[0] == "ROLE_ADMIN_PROFESSEUR"
        ) {
            return $this->render("/admin/catalogue.html.twig");
        }
        return $this->render("/home/home.html.twig");
    }


    #[Route('/admin/manage_resource', name: 'app_catalogue')] // TODO
    public function manageResource() : Response {
        $ues = $this->ueRepository->findAll();
        $users = $this->userRepository->findAll();

        return $this->render("/admin/catalogue.html.twig", [
            'ues' => $ues,
            'users' => $users
        ]);
    }
}