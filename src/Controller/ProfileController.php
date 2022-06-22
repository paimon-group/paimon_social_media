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
    public function newPost(Request $request, PostRepository $postRepository, ManagerRegistry $managerRegistry)
    {
        $imgFile = $_FILES['imgPost'];
        $caption = $request->request->get('captionPost');

        $user = $this->getUser();

        $post = new Post();
        $post->setUser($user);
        $post->setCaption($caption);
        $post->setUploadTime(new \DateTime());
        $database = $managerRegistry->getManager();
        $database->persist($post);
        $database->flush();

        return $this->json(['status'=>'succes',
           'id' => $post->getId()
        ]);
    }


}
