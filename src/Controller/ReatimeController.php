<?php
    namespace App\Controller;

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
            $this->userConnects->attach($conn);
            echo "New connection! (id {$conn->resourceId})\n";
        }

        public function onMessage(ConnectionInterface $from, $msg)
        {
            // TODO: Implement onMessage() method.
        }

        public function onClose(ConnectionInterface $conn)
        {
            // TODO: Implement onClose() method.
        }

        public function onError(ConnectionInterface $conn, \Exception $e)
        {
            // TODO: Implement onError() method.
        }
    }