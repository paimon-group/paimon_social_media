<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route ("/statificalManager", name="app_dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('admin/statifical/adminHome.html.twig');
    }

    /**
     * @Route ("/statifical", name="app_dashboard")
     */
    public function reportManagerdAction()
    {
        return $this->render('admin/statifical/adminHome.html.twig');
    }
}
