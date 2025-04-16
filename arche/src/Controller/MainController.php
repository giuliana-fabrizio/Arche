<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    #[Route('/', name: 'app_login')]
    public function login() : Response {
        return $this->render("login.html.twig");
    }


    #[Route('/admin/manage_resource', name: 'app_catalogue')]
    public function manageResource() : Response {
        return $this->render("/admin/catalogue.html.twig");
    }
}