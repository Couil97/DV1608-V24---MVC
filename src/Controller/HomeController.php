<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function lucky(): Response
    {
        $number = random_int(0, 100);

        if($number > 50) {
            $color = "#00DB16";
        } else {
            $color = "#DB1200";
        }

        $data = [
            'number' => $number,
            'color' => $color
        ];

        return $this->render('lucky.twig', $data);
    }

    #[Route("/session", name: "session")]
    public function session(SessionInterface $session): Response
    {
        $result = '';

        if(!$session->isStarted()) {
            $session->start();
        }

        foreach($session->all() as $key => $value) {
            $result .= "[" . $key . "]: " . $value . "\n";
        }

        if(!$result) {
            $result = "Session empty";
        }

        $data = [
            'session' => $result
        ];

        return $this->render('session.twig', $data);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function delete_session(SessionInterface $session): Response
    {
        $session->invalidate();

        $this->addFlash(
            'notice',
            'Your session has been cleared'
        );

        $result = '';

        if(!$session->isStarted()) {
            $session->start();
        }

        foreach($session->all() as $key => $value) {
            $result .= "[" . $key . "]: " . $value . "\n";
        }

        if(!$result) {
            $result = "Session empty";
        }

        $data = [
            'session' => $result
        ];

        return $this->render('session.twig', $data);
    }
}
