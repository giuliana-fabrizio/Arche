<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {

    #[Route('/create_user', name: 'app_user_create')]
    public function createUser() : Response {
        return $this->render("/admin/user_form.html.twig");
    }

    #[Route('/profile', name: 'app_user_profile')]
    public function manageProfile() : Response {
        return $this->render("/profile/profile.html.twig");
    }
}