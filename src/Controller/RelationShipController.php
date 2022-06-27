<?php
    namespace App\Controller;

    use App\Entity\Relationship;
    use App\Repository\NotificationRepository;
    use App\Repository\ReactionRepository;
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
        public function friendListAction($userId, NotificationRepository $notificationRepository, UserRepository $userRepository, RelationshipRepository $relationshipRepository)
        {
            //get information navbar
            $inforNavBar = $userRepository->getUserInforNavBar($this->getUser()->getId());

            //get total notification of like and comment
            $liekNotification = $notificationRepository->getLikeFromOtherUser($this->getUser()->getId());
            $commentNotification = $notificationRepository->getCommentFromOtherUser($this->getUser()->getId());
            $totalLikeAndCommentNotification = $liekNotification[0]['total_like'] + $commentNotification[0]['total_comment'];

            //get notification of invite friend
            $inviteFriend = $notificationRepository->getInvitefriend($this->getUser()->getId());

            //get detail notification
            $likeAndCommentDetail = $notificationRepository->getCommentAndLikeDetailFromOtherUser($this->getUser()->getId());
            $inviteFriendDetail = $notificationRepository->getInviteFriendDetail($this->getUser()->getId());
            $friendList = $relationshipRepository->getFriendList($userId);

            return $this->render('profile/profileFriendList.html.twig',[
                'inforNavBar' => $inforNavBar,
                'countlikeAndComment' => $totalLikeAndCommentNotification,
                'countInviteFriend' => $inviteFriend,
                'likeAndCommentDetail' => $likeAndCommentDetail,
                'inviteFriendDetail' => $inviteFriendDetail,
                'friendList' => $friendList
            ]);
//            return new JsonResponse(['friendList' => $friendList]);

        }

        /**
         * @Route ("/sendInviteFriend", name="api_add_friend", methods={"PUT"})
         */
        public function sendInviteFriendAPI(Request $request, UserRepository $userRepository, RelationshipRepository $relationshipRepository, ManagerRegistry $managerRegistry)
        {
            $request = $this->tranform($request);
            $friendId = $request->get('userId');
            $sendToFriend = $userRepository->find($friendId);

            if($sendToFriend)
            {

                $relationShip = new Relationship();
                $relationShip->setUser($this->getUser());
                $relationShip->setFriend($sendToFriend);
                $relationShip->setStatus('0');

                $database = $managerRegistry->getManager();
                $database->persist($relationShip);
                $database->flush();

                if($relationshipRepository->checkRelatonshipStatus($this->getUser()->getId(), $friendId) == 2)
                {
                    $relationshipRepository->updateStatus($this->getUser()->getId(), $friendId);
                }

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

        /**
         * @Route ("/acceptFriend", name="api_accept_friend", methods={"PUT"})
         */
        public function acceptFriendAPI(Request $request, UserRepository $userRepository, RelationshipRepository $relationshipRepository, ManagerRegistry $managerRegistry)
        {
            $request = $this->tranform($request);
            $senderId = $request->get('senderId');
            $sender = $userRepository->find($senderId);

            if($sender)
            {
                // save new friend
                $relationShip = new Relationship();
                $relationShip->setUser($this->getUser());
                $relationShip->setFriend($sender);
                $relationShip->setStatus('1');

                $database = $managerRegistry->getManager();
                $database->persist($relationShip);
                $database->flush();

                //update friend status sender
                $relationshipRepository->updateStatus($this->getUser()->getId(), $senderId);

                return new JsonResponse([
                    'status_code' => 200,
                    'Message' => 'Accept friend to user with id: '.$senderId
                ]);
            }
            else
            {
                return new JsonResponse([
                    'status_code' => 400,
                    'Message' => 'Not found user with id: '.$senderId
                ]);
            }

        }

        /**
         * @Route ("/unFriend", name="api_unFriend", methods={"DELETE"})
         */
        public function unFriendAPI(Request $request, RelationshipRepository $relationshipRepository)
        {
            $request = $this->tranform($request);
            $idWantToUnfriend = $request->get('friendId');

            $unFriendResult = $relationshipRepository->unfriend($this->getUser()->getId(), $idWantToUnfriend);

            if($unFriendResult)
            {
                return new JsonResponse(['status_code' => 200, 'Message' => 'Success unfriend with user id: '.$idWantToUnfriend]);
            }
            else
            {
                return new JsonResponse(['status_code' => 400, 'Message' => 'Fail unfriend with user id: '.$idWantToUnfriend]);
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