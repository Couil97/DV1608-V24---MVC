<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PokerController extends AbstractController
{
    #[Route("/proj", name: "proj")]
    public function game(): Response
    {
        return $this->render('game/home.twig');
    }

    #[Route("/proj/poker/start", name: "poker_start")]
    public function poker_start(): Response
    {
        return $this->render('game/home.twig');
    }
}