<?php
    namespace App\Controller;

    use App\Entity\Relationship;
    use App\Repository\RelationshipRepository;
    use App\Repository\UserRepository;
    use Doctrine\Persistence\ManagerRegistry;
    use phpDocumentor\Reflection\Types\This;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Security;

    class RelationShipController extends AbstractController
    {
        /**
         * @Route ("/friendList/{userId}", name="app_friend_list", methods={"GET"})
         */
        public function friendListAction($userId, Request $request, UserRepository $userRepository)
        {
            $inforUser = $userRepository->getUserInforNavBar($userId);
            $inforNavBar = $userRepository->getUserInforNavBar($this->getUser()->getId());

            return $this->render('profile/profileFriendList.html.twig',[
                'inforNavBar' => $inforNavBar,
                'inforUser' => $inforUser,

            ]);

        }

        /**
         * @Route ("/sendInviteFriend", name="api_add_friend", methods={"PUT"})
         */
        public function addFriend(Request $request, UserRepository $userRepository, RelationshipRepository $relationshipRepository, ManagerRegistry $managerRegistry)
        {
            $request = $this->tranform($request);
            $friendId = $request->get('friendId');
            $sendToFriend = $userRepository->find($friendId);

            if($sendToFriend)
            {
                $relationShip = new Relationship();
                $relationShip->setUser($this->getUser());
                $relationShip->setFriend($sendToFriend);

                $database = $managerRegistry->getManager();
                $database->persist($relationShip);
                $database->flush();

                return new JsonResponse([
                    'status_code' => 200,
                    'Message' => 'Has send invite friend to user with id: '.$friendId
                ]);
            }
            else
            {
                return new JsonResponse([
                    'status_code' => 400,
                    'Message' => 'Not found user with id: '.$friendId
                ]);
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