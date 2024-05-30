<?php

namespace App\Controller;

use App\Poker\Gameboard;
use App\Helpers\PokerHelpers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerController extends AbstractController
{
    #[Route("/proj", name: "proj")]
    public function proj(SessionInterface $session): Response
    {
        return $this->render('proj/home.twig');
    }

    #[Route("/proj/about", name: "proj_about")]
    public function proj_about(): Response
    {
        return $this->render('proj/about.twig');
    }

    #[Route("/proj/poker/start", name: "poker_start")]
    public function poker_start(SessionInterface $session): Response
    {
        $data = PokerHelpers::startGame($session, 1, 'Player');
        return $this->render('proj/poker/gameboard.twig', $data);
    }

    #[Route("/proj/poker/draw", name: "poker_draw")]
    public function poker_draw(SessionInterface $session): Response
    {
        $data = PokerHelpers::drawCards($session);

        if($data == []) {
            $this->addFlash(
                'warning',
                'Någonting gick snett!'
            );
            return $this->redirectToRoute('proj');
        }

        return $this->render('proj/poker/gameboard.twig', $data);
    }

    #[Route("/proj/poker/end_round", name: "poker_endRound")]
    public function poker_endRound(SessionInterface $session): Response
    {
        $data = PokerHelpers::endRound($session);

        if($data == []) {
            $this->addFlash(
                'warning',
                'Någonting gick snett!'
            );
            return $this->redirectToRoute('proj');
        }

        return $this->render('proj/poker/gameboard.twig', $data);
    }
    
    #[Route("/proj/poker/bet", name: "poker_bet")]
    public function poker_bet(SessionInterface $session): Response
    {
        $data = PokerHelpers::bet($session);

        if($data == []) {
            $this->addFlash(
                'warning',
                'Någonting gick snett!'
            );
            return $this->redirectToRoute('proj');
        }

        return $this->render('proj/poker/gameboard.twig', $data);
    }
}