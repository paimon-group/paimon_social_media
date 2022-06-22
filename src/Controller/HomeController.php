<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Entity\User;
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
    public function index(PostRepository $postRepository,
                          RelationshipRepository $relationshipRepository,
                          NotificationRepository $notificationRepository)
    {
        $_SESSION['user_id']=$this->getUser()->getId();

        $post = $postRepository->getPost();
        $liekNotification = $notificationRepository->getLikeFromOtherUser($_SESSION['user_id']);
        $commentNotification = $notificationRepository->getCommentFromOtherUser($_SESSION['user_id']);
        $inviteFriend = $notificationRepository->getInvitefriend($_SESSION['user_id']);
        $friendList = $relationshipRepository->getFriendList($_SESSION['user_id']);
        $totalLikeAndComment = $liekNotification[0]['total_like'] + $commentNotification[0]['total_comment'];

        return $this->render('home/homeIndex.html.twig',[
            'post'=>$post,
            'total_like_and_comment' => $totalLikeAndComment,
            'invite_friend' => $inviteFriend
        ]);
    }

}
