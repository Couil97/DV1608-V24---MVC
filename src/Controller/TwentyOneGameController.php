<?php

namespace App\Controller;

use App\Helpers\TwentyOneGameHelpers;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwentyOneGameController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/home.twig');
    }

    #[Route("/game/start", name: "game_start")]
    public function gameStart(SessionInterface $session, TwentyOneGameHelpers $helpers): Response
    {
        // Resets if session is missing variables
        if(!$helpers->validateSession($session)) {
            return $this->redirectToRoute('game_reset');
        }
        $data = $helpers->getData($session);

        return $this->render('game/gameboard.twig', $data);
    }

    #[Route("/game/draw", name: "game_draw")]
    public function gameDraw(SessionInterface $session, TwentyOneGameHelpers $helpers): Response
    {
        // Resets if session is missing variables
        if(!$helpers->validateSession($session)) {
            return $this->redirectToRoute('game_reset');
        }

        // Checks if user has already won/lost
        if($session->get('game-status') != "Running") {
            $data = $helpers->getData($session);
            return $this->render('game/gameboard.twig', $data);
        }

        // Draw new card(s)
        $helpers->drawCard($session);
        $data = $helpers->getData($session);

        return $this->render('game/gameboard.twig', $data);
    }

    #[Route("/game/change_player", name: "game_change_player")]
    public function gameChangePlayer(SessionInterface $session): Response
    {
        $session->set('game-current_player', "bank");
        return $this->redirectToRoute('game_draw');
    }

    #[Route("/game/reset", name: "game_reset")]
    public function gameReset(SessionInterface $session, TwentyOneGameHelpers $helpers): Response
    {
        $helpers->resetHand($session);
        return $this->redirectToRoute('game_start');
    }

    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/doc.twig');
    }
}
