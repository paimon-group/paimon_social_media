<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Repository\NotificationRepository;
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
    public function index(
        PostRepository $postRepository,
        RelationshipRepository $relationshipRepository,
        NotificationRepository $notificationRepository): Response
    {
        $_SESSION['user_Id']=$this->getUser()->getId();
        $post=getPost($postRepository);
        $friendList=getFriendList($relationshipRepository);
        $notification=getNotifications($notificationRepository);
        return $this->render('home/homeIndex.html.twig',[
            'post'=>$post,
            'friendList'=>$friendList,
            'notification'=>$notification
        ]);
    }

    #call get Post function to show post in home page
    public function getPost(PostRepository $postRepository)
    {
        $post=$postRepository->getPost();

        return $this->json(['post'=>$post]);
    }

    #call get friendlist function to show a friend list of crrent user
    public function getFriendList(RelationshipRepository $relationshipRepository)
    {
        $friendList=$relationshipRepository->getFriendList($_SESSION['user_Id']);

         return $this->json(['friendList'=>$friendList]);
    }

    public function getNotifications(NotificationRepository $notificationRepository)
    {
        #call function to count notifications
        $inviteFriend=$notificationRepository->countInvitefriend($_SESSION['user_id']);
        $react=$notificationRepository->getLikeCommentFromOtherUser($_SESSION['user_id']);
        #return value
        return $this->json([
        'inviteFriend'=>$inviteFriend,
        'react'=>$react]);

    }



}
