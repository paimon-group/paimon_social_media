<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Repository\PostRepository;
use App\Repository\RelationshipRepository;
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
        $_SESSION['user_Id']=$this->getUser()->getId();

        return $this->render('home/homeIndex.html.twig');
    }

    #call get Post function to show post in home page
    public function getPost(PostRepository $PostRepository)
    {
        $post=$PostRepository->getPost();

        return $this->json(['post'=>$post]);
    }

    #call get friendlist function to show a friend list of crrent user
    public function getFriendList(RelationshipRepository $RelationshipRepository)
    {
        $friendList=$RelationshipRepository->showFriendList($_SESSION['user_Id']);

         return $this->json(['friendList'=>$friendList]);
    }

    public function displayNotifications(RelationshipRepository $RelationshipRepository)
    {
        
    }



}
