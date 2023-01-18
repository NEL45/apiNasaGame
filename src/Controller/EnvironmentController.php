<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EnvironmentController extends AbstractController
{
    /**
     * @Route("/environnement", name="environnement")
     */
    public function environment()
    {
        $key = 'Uhb88PepnBJsmemDorgenrrjO1qUIovFepIVw5bR';
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://mars-photos.herokuapp.com/api/v1/rovers/Perseverance/photos?earth_date=2021-05-09?api_key=' . $key);
        $statusCode = $response->getStatusCode();
        $maps = ['photos'];

        if ($statusCode === 200) {
            $maps = $response->toArray();
        }
        $maps = [$maps['photos']['33'], $maps['photos']['265'], $maps['photos']['203'], $maps['photos']['269'], $maps['photos']['103'], $maps['photos']['5'], $maps['photos']['77'], $maps['photos']['56']];
        return $this->render('Environment/environment.html.twig', ['maps' => $maps]);
    }
}
