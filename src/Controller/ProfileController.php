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
        return $this->render('profile/profileIndex.html.twig', [
            'error' => $error,
            'caption' => $caption,
            'inforUser' => $userInfor
        ]);
//        return $this->json(['infor' => $userInfor]);
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

        $database = $managerRegistry->getManager();
        $database->persist($user);
        $database->flush($user);

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
    public function newPostAction(Request $request, PostRepository $postRepository, ManagerRegistry $managerRegistry)
    {
        $imgFile = $_FILES['imgPost'];
        $caption = $request->request->get('captionPost');

        if($imgFile['size'] != 0)
        {
            if(!($imgFile["type"] =="image/jpg" || $imgFile['type'] == "image/jpeg" || $imgFile['type'] == "image/png"))
            {
                $error = true;
                $errorMessage = 'Only accept image!';
                return $this->render('profile/profileIndex.html.twig', [
                    'error' => $error,
                    'errorMessage' => $errorMessage,
                    'caption' => $caption
                ]);
            }
            else
            {
                $safeFileImg = uniqid().$imgFile['name'];
                copy($imgFile['tmp_name'], "image/post/".$safeFileImg);
            }
        }

        $user = $this->getUser();
        $post = new Post();
        $post->setUser($user);
        $post->setCaption($caption);
        $post->setImage($safeFileImg);
        $post->setUploadTime(new \DateTime());
        $database = $managerRegistry->getManager();
        $database->persist($post);
        $database->flush();

        return $this->redirectToRoute('app_profile');
    }


}
