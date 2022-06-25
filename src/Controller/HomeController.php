<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Entity\User;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\RelationshipRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

        //get avatar header
        $inforUser = $userRepository->getUserInforNavBar($this->getUser()->getId());

        //get total notification of like and comment
        $liekNotification = $notificationRepository->getLikeFromOtherUser($this->getUser()->getId());
        $commentNotification = $notificationRepository->getCommentFromOtherUser($this->getUser()->getId());
        $totalLikeAndCommentNotification = $liekNotification[0]['total_like'] + $commentNotification[0]['total_comment'];

        //get notification of invite friend
        $inviteFriend = $notificationRepository->getInvitefriend($this->getUser()->getId());

        //get friend list
        $friendList = $relationshipRepository->getFriendList($this->getUser()->getId());

        //get post
        $post = $postRepository->getPost($this->getUser()->getId());

        return $this->render('home/homeIndex.html.twig',[
            'inforUser' => $inforUser,
            'post'=>$post,

        ]);
//        return $this->json(['inforUser' => $inforUser[0]['avatar']]);
    }

    //=====================================Rest API call by AJAX===================================================================

    /**
     * @Route ("/searchUser", name="search_user", methods={"GET"})
     */
    public function searchUser(Request $request, UserRepository $userRepository)
    {
        $request = $this->tranform($request);
        $userFullname = $request->get('fullname');

        $userList = $userRepository->searchUserWithFullName($userFullname);

        if($userList)
        {
//            return $this->render('home/searchFriend.html.twig');
            return new JsonResponse(['status_code' => 200, 'userList' => $userList]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Not found user with name: '.$userFullname]);
        }
    }

        public function tranform($request){
        $data = json_decode($request->getContent(), true);
        if($data === null){
            return $request;
        }
        $request->request->replace($data);
        return $request;
    }

}
