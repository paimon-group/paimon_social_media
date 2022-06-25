<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Reaction;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
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
    public function likeAction(Request $request, PostRepository $postRepository, ReactionRepository $reactionRepository, ManagerRegistry $managerRegistry): Response
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
                $post->setTotalLike($post->getTotalLike() + 1);

                $reaction->setUser($this->getUser());
                $reaction->setPost($post);

                $database = $managerRegistry->getManager();

                $database->persist($reaction);
                $database->flush();

                $database->persist($post);
                $database->flush();

                return new JsonResponse(['status_code' => 200, 'Message' => 'Like success with post id: '.$idPostWantLike]);
            }
            else
            {
                $post->setTotalLike($post->getTotalLike() - 1);

                $database = $managerRegistry->getManager();
                $database->persist($post);
                $database->flush();

                $reactionid = $reactionRepository->getReactionId($this->getUser()->getId(), $idPostWantLike);

                $reactionWantDelete = $reactionRepository->find($reactionid[0]['id']);

                $database->remove($reactionWantDelete);
                $database->flush();
                return new JsonResponse(['status_code' => 200, 'Message' => 'Un like success with post id: '.$idPostWantLike, 'remove' => $reactionid[0]['id']]);
            }

        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Post id: '.$idPostWantLike.' not found' ]);
        }

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
