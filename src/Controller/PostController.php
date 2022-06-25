<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="app_post")
     */
    public function index(UserRepository $userRepository): Response
    {
        $inforUser = $userRepository->getUserInforNavBar($this->getUser()->getId());
        return $this->render('test.html.twig', [
            'inforUser' => $inforUser
        ]);
    }
}
