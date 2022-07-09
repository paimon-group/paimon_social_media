<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\Type\changesPasswordFormType;
use App\Form\Type\updateProfileFormType;
use App\Repository\CommentRepository;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
use App\Repository\RelationshipRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ProfileController extends AbstractController
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/profile/{userId}", name="app_profile", methods={"GET"})
     */
    public function index($userId, CommentRepository $commentRepository, NotificationRepository $notificationRepository, RelationshipRepository $relationshipRepository, UserRepository $userRepository, PostRepository $postRepository, ReactionRepository $reactionRepository)
    {
        $error = false;
        $caption = '';
        $relationshipStatus = '';
        $user = $userRepository->find($userId);
        if($user)
        {
            //get infor navbar
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

            //get data user
            $userInfor = $userRepository->getProfile($userId);
            $posts = $postRepository->getPostProfile($userId);
            $postLiked = $reactionRepository->checklike($this->getUser()->getId());

            //get comment
            $comments = $commentRepository->getFullComment();

            if($userId != $this->getUser()->getId())
            {
                $relationshipStatus = $relationshipRepository->checkRelatonshipStatus($this->getUser()->getId(), $userId);
                return $this->render( 'profile/profileIndex.html.twig',[
                    'error' => $error,
                    'caption' => $caption,
                    'inforNavBar' => $inforNavBar,
                    'countlikeAndComment' => $totalLikeAndCommentNotification,
                    'countInviteFriend' => $inviteFriend,
                    'likeAndCommentDetail' => $likeAndCommentDetail,
                    'inviteFriendDetail' => $inviteFriendDetail,
                    'inforUser' => $userInfor,
                    'posts' => $posts,
                    'postLiked' => $postLiked,
                    'comments' => $comments,
                    'friendStatus' => $relationshipStatus,
                ]);
            }
            else
            {
                return $this->render('profile/profileIndex.html.twig', [
                    'error' => $error,
                    'caption' => $caption,
                    'inforNavBar' => $inforNavBar,
                    'countlikeAndComment' => $totalLikeAndCommentNotification,
                    'countInviteFriend' => $inviteFriend,
                    'likeAndCommentDetail' => $likeAndCommentDetail,
                    'inviteFriendDetail' => $inviteFriendDetail,
                    'inforUser' => $userInfor,
                    'posts' => $posts,
                    'postLiked' => $postLiked,
                    'comments' => $comments,
                    'friendStatus' => $relationshipStatus,
                ]);
            }
        }
        else
        {
            return new JsonResponse(['status_code' => 400]);
        }
    }

    /**
     * @Route ("/updateInformation", name="app_update_profile", methods={"POST", "GET"})
     */
    public function updateInforProfileAction(Request $request, NotificationRepository $notificationRepository, UserRepository $userRepository, ValidatorInterface $validator, ManagerRegistry $managerRegistry)
    {
        //get infor navbar
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

        $inforUser = $userRepository->getUserInforNavBar($this->getUser()->getId());

        // update infor
        $errorUpdateInfor = null;
        $user = new User();
        $formUpdateInfor = $this->createForm(updateProfileFormType::class, $user);
        $formUpdateInfor->handleRequest($request);

        if($formUpdateInfor->isSubmitted())
        {
            if($formUpdateInfor->isValid())
            {
                $user = $this->getUser();
                $dataInforUpdate = $formUpdateInfor->getData();

                $this->saveInforUser($dataInforUpdate, $user, $managerRegistry);

                $formUpdateInfor = $this->createForm(updateProfileFormType::class, $user);
            }
            else
            {
                $errorUpdateInfor = $validator->validate($user);
            }

        }
        else
        {
            $inforUpdate = $userRepository->getProfile($this->getUser()->getId());

            $user->setFullname($inforUpdate[0]['fullname']);
            $user->setEmail($inforUpdate[0]['email']);
            $user->setGender($inforUpdate[0]['gender']);
            $user->setPhone($inforUpdate[0]['phone']);
            $user->setAddress($inforUpdate[0]['address']);
            $formUpdateInfor = $this->createForm(updateProfileFormType::class, $user);
        }


        return $this->render('profile/profileUpdateInfor.html.twig',[
            'inforNavBar' => $inforNavBar,
            'countlikeAndComment' => $totalLikeAndCommentNotification,
            'countInviteFriend' => $inviteFriend,
            'likeAndCommentDetail' => $likeAndCommentDetail,
            'inviteFriendDetail' => $inviteFriendDetail,
            'errorUpdateInfor' => $errorUpdateInfor,
            'inforUser' => $inforUser,
            'updateInforForm' => $formUpdateInfor->createView()
        ]);

    }

    public function saveInforUser ($dataInforUpdate, $user, $managerRegistry)
    {
        $user->setFullname($dataInforUpdate->getFullname());
        $user->setGender($dataInforUpdate->getGender());
        $user->setEmail($dataInforUpdate->getEmail());
        $user->setPhone($dataInforUpdate->getPhone());
        $user->setAddress($dataInforUpdate->getAddress());

        $database = $managerRegistry->getManager();
        $database->persist($user);
        $database->flush();
    }


    //=====================================Routing for API request by AJAX=================================

    /**
     * @Route ("/profile/changeAvatar", name="api_change_avatar", methods="POST")
     */
    public function changeAvatarProfileAPI(ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $caption = $_POST['captionChangeAvatar'];
        $imgFile = $_FILES['imgAvatar'];

        $error = $this->checkPost($imgFile, $caption);

        if($error != '')
        {
            return new JsonResponse(['status_code' => 400, 'Message' => $error]);
        }
        $safeFileImg = uniqid().$imgFile['name'];
        copy($imgFile['tmp_name'], "image/post/".$safeFileImg);

        //get user data
        $userId = $this->getUser()->getId();
        $user = $userRepository->find($userId);

        //set data for user
        $user->setAvatar($safeFileImg);

        //save infor user
        $database = $managerRegistry->getManager();
        $database->persist($user);
        $database->flush($user);

        $post = new Post();
        $post->setUser($user);
        $post->setCaption($caption);
        $post->setImage($safeFileImg);
        $post->setUploadTime(new \DateTime());
        $post->setDeleted('false');

        $database->persist($post);
        $database->flush();

        return new JsonResponse([
            'status_code' => 200,
            'Message' => 'success',
            'userId' => $this->getUser()->getId()
        ]);
    }


    public function checkPost($imgFile, $caption)
    {
        $error = '';
        if($imgFile['name'] != '')
        {
            if(!($imgFile["type"] =="image/jpg" || $imgFile['type'] == "image/jpeg" || $imgFile['type'] == "image/png"))
            {
                  $error = 'Only accept image';
            }
        }
        else if($imgFile['name'] == '' && $caption == '')
        {
            $error = 'content is empty';
        }

        return $error;
    }

    public function tranform($request){
        $data = json_decode($request->getContent(), true);
        if($data === null){
            return $request;
        }
        $request->request->replace($data);
        return $request;
    }

    /**
     * @Route("/changePassword", name="change_password", methods={"POST", "GET"})
     */
    public function changePassword(Request $request,UserPasswordHasherInterface $hasher,UserRepository $userRepository,ManagerRegistry $managerRegistry): Response
    {
        $user = new user();
        $changePassword = $this->createForm(changesPasswordFormType::class,$user);

        $changePassword->handleRequest($request);
        $error = false;
        $message = "";

        if($changePassword->isSubmitted())
        {
            if($changePassword->isValid())
            {
                $password = $this->getUser();
                $oldPassword = $request->request->get('password');
                $newPassword = $request->request->get('newPassword');
                $confirmPassword = $request->request->get('confirmPassword');

                if ($hasher->isPasswordValid($password, $oldPassword))
                {
                    if ($newPassword == $confirmPassword && $newPassword!='')
                    {
                        $User = $this->getUser();
                        $User->setPassword($this->passwordHasher->HashPassword($user, $newPassword));

                        $database = $managerRegistry->getManager();
                        $database->persist($User);
                        $database->flush();
                        $message = 'Change Password is success';
                    }
                    else
                    {
                        $error = true;
                        $message = 'Confirm password not match!';
                    }
                }
                else
                {
                    $error = true;
                    $message = 'Incorrect Current Password ';
                }

            }
            else
            {
                $error = true;
                $message = 'invalid Password';
            }
        }

        return $this->render('profile/changePassword.html.twig', [
            'error' => $error,
            'message' => $message,
            'changes_password' => $changePassword->createView()
        ]);
    }
}
