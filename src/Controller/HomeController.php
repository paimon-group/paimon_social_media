<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/homeIndex.html.twig');
    }
    public function getPost(PostRepository $repo)
    {
        $post=$repo->getPost();
        return $this->json(['post'=>$post]);
    }

}
