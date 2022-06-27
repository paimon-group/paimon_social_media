<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Notification;
use App\Entity\Reaction;
use App\Repository\NotificationRepository;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction/like", name="app_reaction_like", methods={"PUT"})
     */
    public function likeAction(Request $request ,UserRepository $userRepository,PostRepository $postRepository, ReactionRepository $reactionRepository, ManagerRegistry $managerRegistry): Response
    {
        $request = $this->tranform($request);

        $idPostWantLike = $request->get('idPost');
        $optionLike = $request->get('optionLike');

        $post = $postRepository->find($idPostWantLike);
        $reaction = new  Reaction();

        $database = $managerRegistry->getManager();
        if($post)
        {
            if($optionLike == 'like')
            {
                $this->saveLike($reaction, $database, $post, $postRepository, $idPostWantLike, $userRepository);
                return new JsonResponse(['status_code' => 200, 'Message' => 'Like success with post id: '.$idPostWantLike]);
            }
            else
            {
                $reactionid = $this->unlike($post, $database, $reactionRepository, $idPostWantLike);
                return new JsonResponse(['status_code' => 200, 'Message' => 'Un like success with post id: '.$idPostWantLike, 'remove' => $reactionid[0]['id']]);
            }
        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Post id: '.$idPostWantLike.' not found' ]);
        }
    }
    function saveLike($reaction, $database, $post, $postRepository, $idPostWantLike, $userRepository)
    {
        //save like
        $reaction->setUser($this->getUser());
        $reaction->setPost($post);

        $database->persist($reaction);
        $database->flush();

        //save total like
        $post->setTotalLike($post->getTotalLike() + 1);
        $database->persist($reaction);
        $database->flush();

        //save notificacation
        $receiverId = $postRepository->getUserIdFromAPost($idPostWantLike);
        $receiver = $userRepository->find($receiverId[0]['id']);

        $notification = new Notification();
        $notification->setSender($this->getUser());
        $notification->setReceiver($receiver);
        $notification->setType('like');
        $notification->setSeen('no');

        $database->persist($notification);
        $database->flush();
    }
    function unlike($post, $database, $reactionRepository, $idPostWantLike)
    {
        //save total like
        $post->setTotalLike($post->getTotalLike() - 1);

        $database->persist($post);
        $database->flush();

        //remove like reaction
        $reactionid = $reactionRepository->getReactionId($this->getUser()->getId(), $idPostWantLike);
        $reactionWantDelete = $reactionRepository->find($reactionid[0]['id']);

        $database->remove($reactionWantDelete);
        $database->flush();

        return $reactionid;
    }


    //tranform data when request by PUT method
    public function tranform($request){
        $data = json_decode($request->getContent(), true);
        if($data === null){
            return $request;
        }
        $request->request->replace($data);
        return $request;
    }
}
