<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Relationship;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\MessagesRepository;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
use App\Repository\RelationshipRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route ("/processWebSocket", name="process_web_socket")
     */
    public function processWebSocket(UserRepository $userRepository, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($this->getUser()->getId());
        $user->setLoginStatus('online');

        $database = $managerRegistry->getManager();
        $database->persist($user);
        $database->flush();

        return $this->redirectToRoute('app_home');
    }
    
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ReactionRepository $reactionRepository, CommentRepository $commentRepository, UserRepository $userRepository, PostRepository $postRepository, RelationshipRepository $relationshipRepository, NotificationRepository $notificationRepository)
    {
        //get avatar header
        $inforNavBar = $userRepository->getUserInforNavBar($this->getUser()->getId());

        //get total notification of like and comment
        $likeNotification = $notificationRepository->getLikeFromOtherUser($this->getUser()->getId());
        $commentNotification = $notificationRepository->getCommentFromOtherUser($this->getUser()->getId());
        $deletePostNotification = $notificationRepository->getReportFromOtherUser($this->getUser()->getId());
        $totalLikeAndCommentNotification = $likeNotification[0]['total_like'] + $commentNotification[0]['total_comment'] + $deletePostNotification[0]['total_report'];

        //get notification of invite friend
        $inviteFriend = $notificationRepository->getInvitefriend($this->getUser()->getId());

        //get detail notification
        $likeAndCommentDetail = $notificationRepository->getCommentAndLikeDetailFromOtherUser($this->getUser()->getId());
        $inviteFriendDetail = $notificationRepository->getInviteFriendDetail($this->getUser()->getId());
        //get friend list
        $friendList = $relationshipRepository->getFriendList($this->getUser()->getId());

        //get post and data user
        $post = $postRepository->getPost($this->getUser()->getId());
        $postLiked = $reactionRepository->checklike($this->getUser()->getId());
        $userInfor = $userRepository->getProfile($this->getUser()->getId());

        //get comment
        $comments = $commentRepository->getFullComment();

        $friendSuggest = $relationshipRepository->getFriendSuggest($this->getUser()->getId());
        return $this->render('home/homeIndex.html.twig',[
            'inforNavBar' => $inforNavBar,
            'countlikeAndComment' => $totalLikeAndCommentNotification,
            'countInviteFriend' => $inviteFriend,
            'likeAndCommentDetail' => $likeAndCommentDetail,
            'inviteFriendDetail' => $inviteFriendDetail,
            'inforUser' => $userInfor,
            'posts'=> $post,
            'postLiked' => $postLiked,
            'comments' => $comments,
            'friendList' => $friendList,
            'friendSuggest' => $friendSuggest
        ]);
    }

    /**
     * @Route ("/aboutUs", name="app_about_us")
     */
    public function aboutUsAction()
    {
        return $this->render('home/aboutUs.html.twig');
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
             return new JsonResponse(['status_code' => 200, 'userList' => $userList]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Not found user with name: '.$userFullname]);
        }
    }

    /**
     * @Route ("/saveMessage", name="api_save_message", methods="PUT")
     */
    public function saveMessageAPI(Request $request, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {
        $request = $this->tranform($request);
        $userId = $request->get('userId');
        $user = $userRepository->find($userId);
        $contentMessage = $request->get('content');
        $time = $request->get('time');

        if($user)
        {
            if($userId == $this->getUser()->getId())
            {
                $message = new Messages();
                $message->setUser($user);
                $message->setMessage($contentMessage);
                $time = \DateTime::createFromFormat('Y-m-d h:i:s', $time);
                $message->setTime($time);

                $database =  $managerRegistry->getManager();
                $database->persist($message);
                $database->flush();
            }

            return new JsonResponse(['status_code' => 200, 'Message' => 'save success message with user id: '.$userId]);
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Not found user id: '.$userId]);
        }

    }

    /**
     * @Route ("/getMessage", name="getMessage", methods="GET")
     */
    public function getMessage(MessagesRepository $messagesRepository)
    {
        $dataMessage = $messagesRepository->getAllMessage();
        return new JsonResponse([$dataMessage]);
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
