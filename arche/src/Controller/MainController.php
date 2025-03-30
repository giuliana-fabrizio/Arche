<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    #[Route('/', name: 'app_index')]
    public function homepage() : Response {
        return $this->render("base.html.twig");
    }

    #[Route('/create_post', name: 'app_post_create')]
    public function createUe() : Response {
        return $this->render("/teacher/post_form.html.twig");
    }

    #[Route('/manage_resource', name: 'app_catalogue')]
    public function manageResource() : Response {
        return $this->render("/admin/catalogue.html.twig");
    }
}