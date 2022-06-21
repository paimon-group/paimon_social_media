<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $_SESSION=$this->getUser()->getUsername();
        return $this->render('home/homeIndex.html.twig');
    }
    public function getPost(PostRepository $repo)
    {
        $post=$repo->getPost();
        return $this->json(['post'=>$post]);
    }
    public function getUserNameOfUser()
    {
        $user = $this->getUser();
        return $this->json(['username' => $user->getUsername()]);
    }

}
