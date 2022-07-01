<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;

    class GameController extends AbstractController
    {
        /**
         * @Route ("/playGame", name="app_play_game" )
         */
        public function playGame()
        {
            return $this->render('game/game.html.twig');
        }
    }