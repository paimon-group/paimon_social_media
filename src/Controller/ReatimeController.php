<?php
    namespace App\Controller;

    use App\Entity\User;
    use App\Repository\UserRepository;

    use Ratchet\MessageComponentInterface;
    use Ratchet\ConnectionInterface;

    class ReatimeController implements MessageComponentInterface
    {
        protected $userConnects;

        public function __construct()
        {
            $this->userConnects = new \SplObjectStorage();
        }

        public function onOpen(ConnectionInterface $conn)
        {
            $querystring = $conn->httpRequest->getUri()->getquery();
            $this->userConnects->attach($conn);
            echo "New connection! (id {$conn->resourceId} session: })\n";
        }

        public function onMessage(ConnectionInterface $from, $msg)
        {
            $reciverNumber = count($this->userConnects) - 1;
            echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
                , $from->resourceId, $msg, $reciverNumber, $reciverNumber == 1 ? '' : 's');
            foreach ($this->userConnects as $user)
            {
                $user->send($msg);
            }
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