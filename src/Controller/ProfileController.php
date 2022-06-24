<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\Type\updateProfileFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use phpDocumentor\Reflection\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    //=====================================Routing for API request by AJAX=================================

    /**
     * @Route ("/profile/changeAvatar", name="app_change_avatar", methods="POST")
     */
    public function changeAvatarProfileAction(ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {

        $caption = $_POST['captionChangeAvatar'];
        $imgFile = $_FILES['imgAvatar'];

        $error = $this->checkPost($imgFile, $caption);

        if($error != '')
        {
            return new JsonResponse(['notification' => $error]);
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

        return new JsonResponse(['notification' => 'success']);
    }


    /**
     * @Route ("/Post/new", name="app_new_post", methods="POST")
     */
    public function newPostAction(PostRepository $postRepository, ManagerRegistry $managerRegistry, UserRepository $userRepository)
    {
        $imgFile = $_FILES['imgPost'];
        $caption = $_POST['captionPost'];

        $error = $this->checkPost($imgFile, $caption);

        if($error != '')
        {
            return new JsonResponse(['notification' => $error]);
        }
        else
        {
            $post = new Post();
            $user = $this->getUser();

            if($imgFile['name'] != '')
            {
                $safeFileImg = uniqid().$imgFile['name'];
                copy($imgFile['tmp_name'], "image/post/".$safeFileImg);
                $post->setImage($safeFileImg);
            }

            $post->setUser($user);
            $post->setCaption($caption);
            $post->setUploadTime(new \DateTime());
            $post->setDeleted('false');

            //save data
            $database = $managerRegistry->getManager();
            $database->persist($post);
            $database->flush();

            return new JsonResponse(['notification' => 'success']);
        }

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
        else if($imgFile['name'] != '' && $caption == '')
        {
            $error = 'content is empty';
        }

        return $error;
    }

    /**
     * @Route ("/profile/deletePost", name="app_delete_post", methods="POST")
     */
    public function deletePostAction(PostRepository $postRepository, ManagerRegistry $managerRegistry)
    {
        $idPost = $_POST['idPost'];

        $post = $postRepository->find($idPost);

        if($post)
        {

            if($post->getImage() != null)
            {
                unlink('image/post/'.$post->getImage());
            }

            $post->setDeleted('true');

            $database = $managerRegistry->getManager();
            $database->persist($post);
            $database->flush();

            return new JsonResponse(['notification' => 'success', 'id' => $idPost]);
        }
        else
        {
            return new JsonResponse(['notification' => 'fail', 'id' => $idPost]);
        }

    }

    /**
     * @Route ("/post/getInforPost", name="app_edit_post", methods="GET")
     */
    public function editPostAction(PostRepository $postRepository)
    {
        $idPost = $_GET['idPost'];

        $post = new Post();
        $post = $postRepository->find($idPost);

        return new JsonResponse([
            'status' => 'success',
            'caption' => $post->getCaption(),
            'image' => $post->getImage()
        ]);
    }
}
