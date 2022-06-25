<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReactionController extends AbstractController
{
    /**
     * @Route("/reaction/like", name="app_reaction_like", methods={"PUT"})
     */
    public function likeAction(Request $request, PostRepository $postRepository, ManagerRegistry $managerRegistry): Response
    {
        $request = $this->tranform($request);

        $idPostWantLike = $request->get('idPost');
        $optionLike = $request->get('optionLike');

        $post = $postRepository->find($idPostWantLike);

        if($post)
        {
            if($optionLike == 'like')
            {
                $post->setTotalLike($post->getTotalLike() + 1);

                $database = $managerRegistry->getManager();
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

                return new JsonResponse(['status_code' => 200, 'Message' => 'Un like success with post id: '.$idPostWantLike]);
            }

        }
        else
        {
            return new JsonResponse(['status_code' => 400, 'Message' => 'Post id: '.$idPostWantLike.' not found' ]);
        }

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
