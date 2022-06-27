<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;

    class NotificationController extends AbstractController
    {
        /**
         * @Route ("/seenNotification", name="api_seen_notification", methods={"PUT"})
         */
        public function seenNotificationAPI(Request $request)
        {
            $request = $this->tranform($request);
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