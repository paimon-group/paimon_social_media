<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\Type\updateProfileFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(UserRepository $userRepository, PostRepository $postRepository)
    {
        session_start();
        $error = false;
        $caption = '';

        $userInfor = $userRepository->getProfile($_SESSION['user_id']);
        $posts = $postRepository->getPostProfile($_SESSION['user_id']);

        return $this->render('profile/profileIndex.html.twig', [
            'error' => $error,
            'caption' => $caption,
            'inforUser' => $userInfor,
            'posts' => $posts
        ]);
//        return $this->json([
//            'error' => $error,
//            'inforUser' => $userInfor,
//            'posts' => $posts
//        ]);
    }

    /**
     * @Route ("/profile/changeAvatar", name="app_change_avatar", methods="POST")
     */
    public function changeAvatarProfileAction(ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $caption = $_POST['captionChangeAvatar'];
        $imgFile = $_FILES['imgAvatar'];
        $userId = $_POST['userId'];

        if(!($imgFile["type"] =="image/jpg" || $imgFile['type'] == "image/jpeg" || $imgFile['type'] == "image/png"))
        {
            $error = true;
            $errorMessage = 'Only accept image!';
            $userInfor = $userRepository->getProfile($_SESSION['user_id']);
            return $this->render('profile/profileIndex.html.twig', [
                'error' => true,
                'errorChangeAvatar' => $error,
                'errorMessage' => $errorMessage,
                'caption' => $caption,
                'inforUser' => $userInfor
            ]);
        }
        else
        {
            $safeFileImg = uniqid().$imgFile['name'];
            copy($imgFile['tmp_name'], "image/avatar/".$safeFileImg);
        }

        //get user data
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

        $database->persist($post);
        $database->flush();

        return $this->redirectToRoute('app_profile');
    }

    /**
     * @Route ("/profile/updateInformation", name="app_update_profile")
     */
    public function updateInforProfileAction()
    {
        $user = new User();
        $formUpdateInfor = $this->createForm(updateProfileFormType::class, $user);
        return $this->render('profile/profileUpdateInfor.html.twig',[
            'updateInforForm' => $formUpdateInfor->createView()
        ]);
    }

    /**
     * @Route ("/Post/new", name="new_post", methods="POST")
     */
    public function newPostAction(PostRepository $postRepository, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {
        $imgFile = $_FILES['imgPost'];
        $caption = $_POST['captionPost'];
        $error = false;
        $error = $this->checkPost($imgFile, $caption);

        if($error != '')
        {
            return $this->json(['error' => $error]);
        }
        else
        {
            $safeFileImg = uniqid().$imgFile['name'];
            copy($imgFile['tmp_name'], "image/post/".$safeFileImg);

            $post = new Post();
            $user = $this->getUser();

            $post->setImage($safeFileImg);
            $post->setUser($user);
            $post->setCaption($caption);
            $post->setUploadTime(new \DateTime());

            //save data
            $database = $managerRegistry->getManager();
            $database->persist($post);
            $database->flush();

            return $this->redirectToRoute('app_profile');
        }

    }

    public function checkPost($imgFile, $caption)
    {
        if($imgFile['name'] != '' && $caption != '')
        {
            if(!($imgFile["type"] =="image/jpg" || $imgFile['type'] == "image/jpeg" || $imgFile['type'] == "image/png"))
            {
                  $error = 'Only accept image';
            }
        }
        else
        {
            $error = 'content is empty';
        }
        return $error;
    }
}
