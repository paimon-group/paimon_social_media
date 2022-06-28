<?php
    namespace App\Controller;

    use App\Entity\User;
    use App\Repository\ReactionRepository;
    use App\Repository\UserRepository;
    use Cassandra\Date;
    use Doctrine\Persistence\ManagerRegistry;
    use phpDocumentor\Reflection\Element;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Routing\Annotation\Route;
    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use DateTimeZone;

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    class RealtimeController extends AbstractController implements MessageComponentInterface
    {
        protected $userConnects;

        public function __construct()
        {
            $this->userConnects = new \SplObjectStorage();
        }


        public function onOpen(ConnectionInterface $conn)
        {
            $this->userConnects->attach($conn);

            echo "New connection! (id {$conn->resourceId})\n";
        }

        public function onMessage(ConnectionInterface $from, $msg)
        {
            $reciverNumber = count($this->userConnects) - 1;
            $msg = json_decode($msg, true);
            $msg['time'] = date('Y-m-d h:i:s');



            foreach ($this->userConnects as $user)
            {
                if($user == $from)
                {
                    $msg['from'] = 'me';
                }
                else
                {
                    $msg['from'] = 'friend';
                }
                $user->send(json_encode($msg));
            }

            $msg = json_encode($msg);
            echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
                , $from->resourceId, $msg, $reciverNumber, $reciverNumber == 1 ? '' : 's');
        }

        public function onClose(ConnectionInterface $conn)
        {
            $this->userConnects->detach($conn);
            echo "Connection {$conn->resourceId} has disconnected\n";
        }

        public function onError(ConnectionInterface $conn, \Exception $e)
        {
            echo "An error has occurred: {$e->getMessage()}\n";
            $conn->close();
        }
    }