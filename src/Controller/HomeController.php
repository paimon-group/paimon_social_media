<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Entity\User;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\RelationshipRepository;
use App\Repository\UserRepository;
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
    public function index(UserRepository $userRepository,PostRepository $postRepository, RelationshipRepository $relationshipRepository, NotificationRepository $notificationRepository)
    {
        session_start();
        $_SESSION['user_id'] = $this->getUser()->getId();

        //get avatar header
        $inforUser = $userRepository->getUserInforNavBar($_SESSION['user_id']);

        //get total notification of like and comment
        $liekNotification = $notificationRepository->getLikeFromOtherUser($_SESSION['user_id']);
        $commentNotification = $notificationRepository->getCommentFromOtherUser($_SESSION['user_id']);
        $totalLikeAndCommentNotification = $liekNotification[0]['total_like'] + $commentNotification[0]['total_comment'];

        //get notification of invite friend
        $inviteFriend = $notificationRepository->getInvitefriend($_SESSION['user_id']);

        //get friend list
        $friendList = $relationshipRepository->getFriendList($_SESSION['user_id']);

        //get post
        $post = $postRepository->getPost($_SESSION['user_id']);

        return $this->render('home/homeIndex.html.twig',[
            'inforUser' => $inforUser,
            'post'=>$post,

        ]);
//        return $this->json(['inforUser' => $inforUser[0]['avatar']]);
    }

}
