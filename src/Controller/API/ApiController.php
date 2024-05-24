<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api-home.twig');
    }

    #[Route("/api/quote", name: "quote")]
    public function quote(): Response
    {
        $random = random_int(0, 3);
        date_default_timezone_set('Europe/Stockholm');

        $quotes = [
                "Idag är en av dagarna någonsin",
                "Imorgon kan vara idag, om idag är imorgon",
                "Gårdagens idag är dagens gårdag",
                "Övermorgon är dagen efter imorgondagens morgon"
        ];

        $data = [
            'qoute' => $quotes[$random],
            'date' => date("d-m-y"),
            'timestamp' => date('H:i:s')
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
