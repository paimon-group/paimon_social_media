<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\Type\updateProfileFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index()
    {
        return $this->render('profile/profileIndex.html.twig');
    }

    /**
     * @Route ("/profile/updateInformation", name="app_update_profile")
     */
    public function updateInforProfile()
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
    public function newPost(Request $request, PostRepository $postRepository)
    {
        $imgFile = $_FILES['imgPost'];
        $caption = $request->request->get('captionPost');

        $post = new Post();
        $post->setUser($_SESSION['user_id']);
        $post->setCaption($caption);
        $post->setUploadTime(new \DateTime());
        $post->setTotalComment(0);
        $post->setTotalLike(0);


        return $this->json(['status'=>'succes',
           'image' => $imgFile,
           'caption' => $caption
        ]);
    }


}
