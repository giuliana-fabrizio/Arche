<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UeController extends AbstractController {

    #[Route('/create_ue', name: 'app_ue_create')]
    public function createUe() : Response {
        return $this->render("/admin/ue_form.html.twig");
    }

    #[Route('/choose_ue', name: 'app_ue_choose')]
    public function chooseUe() : Response {
        return $this->render("/home/home.html.twig");
    }

    #[Route('/', name: 'app_ue_content')]
    public function getUe() : Response {
        return $this->render("/profile/catalogue.html.twig");
    }
}