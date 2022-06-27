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

        if($post)
        {
            if($optionLike == 'like')
            {
                $this->saveLike($post, $reaction, $managerRegistry);
                $this->saveNotification($idPostWantLike, $postRepository, $userRepository, $managerRegistry);

                return new JsonResponse(['status_code' => 200, 'Message' => 'Like success with post id: '.$idPostWantLike]);
            }
            else
            {
                $this->unlike($post, $managerRegistry, $reactionRepository, $idPostWantLike);
                return new JsonResponse(['status_code' => 200, 'Message' => 'Un like success with post id: '.$idPostWantLike, 'remove' => $reactionid[0]['id']]);
            }

        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Post id: '.$idPostWantLike.' not found' ]);
        }

    }

    function saveLike($post, $reaction, $managerRegistry)
    {
        $post->setTotalLike($post->getTotalLike() + 1);

        $reaction->setUser($this->getUser());
        $reaction->setPost($post);

        $database = $managerRegistry->getManager();

        $database->persist($reaction);
        $database->flush();

        $database->persist($post);
        $database->flush();
    }

    function saveNotification($idPostWantLike, $postRepository, $userRepository, $managerRegistry)
    {
        $receiverId = $postRepository->getUserIdFromAPost($idPostWantLike);
        $receiver = $userRepository->find($receiverId);

        $notification = new Notification();
        $notification->setSender($this->getUser());
        $notification->setReceiver($receiver);
        $notification->setType('like');
        $notification->setSeen('no');

        $database = $managerRegistry->getManager();
        $database->persist($notification);
        $database->flush();
    }

    function unlike($post, $managerRegistry, $reactionRepository, $idPostWantLike)
    {
        $post->setTotalLike($post->getTotalLike() - 1);

        $database = $managerRegistry->getManager();
        $database->persist($post);
        $database->flush();

        $reactionid = $reactionRepository->getReactionId($this->getUser()->getId(), $idPostWantLike);

        $reactionWantDelete = $reactionRepository->find($reactionid[0]['id']);

        $database->remove($reactionWantDelete);
        $database->flush();
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
