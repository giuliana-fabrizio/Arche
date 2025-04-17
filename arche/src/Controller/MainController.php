<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

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
        return $this->render("/admin/catalogue.html.twig");
    }
}