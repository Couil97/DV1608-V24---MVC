<?php

namespace App\Controller;

use App\CardGame\CardDeck;
use App\Helpers\CardGameHelpers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/proj", name: "project")]
    public function proj(): Response
    {
        return $this->render('proj/home.twig');
    }

    #[Route("/proj/poker/start", name: "poker_start")]
    public function poker_start(SessionInterface $session, TwentyOneGameHelpers $helpers): Response
    {
        // Resets if session is missing variables
        if(!$helpers->validateSession($session)) {
            return $this->redirectToRoute('game_reset');
        }
        $data = $helpers->getData($session);

        return $this->render('game/gameboard.twig', $data);
    }
}