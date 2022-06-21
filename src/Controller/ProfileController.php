<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(): Response
    {
        return $this->render('profile/profileIndex.html.twig');
    }

    /**
     * @Route ("/profile/updateInformation", name="app_update_profile")
     */
    public function updateInforProfile()
    {
        return $this->render('profile/profileUpdateInfor.html.twig');
    }
}
