<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class GameController extends AbstractController
{
    #[Route('/game/', name: 'game')]
    public function index(): Response
    {
        $robotPercy = [
            'name' => 'Percy', 'attacks' => ['Coup de caméra', 'Rouler', 'Lanceur de filet'],
            'img' => 'build/images/game/Percyx600.jpg'
        ];
        $robotGinny = [
            'name' => 'Ginny', 'attacks' => ['Coup d\'hélice', 'Charge', 'Réfléxion solaire'],
            'img' => 'build/images/game/Ginnyx600.jpg'
        ];
        $cardEmpty = ['name' => ''];
        $robots = [$robotPercy, $cardEmpty, $robotGinny];

        return $this->render('Game/index.html.twig', [
            'robots' => $robots,
        ]);
    }

    #[Route('/gamewinner/{robotSelected}', name: 'game_winner', methods: ['GET', 'POST'])]
    public function readyToGo(string $robotSelected): Response
    {   
        $robotPercy = [
            'name' => 'Percy', 'attacks' => ['Coup de caméra', 'Rouler', 'Lanceur de filet'],
            'img' => 'build/images/game/Percyx600.jpg'
        ];
        $robotGinny = [
            'name' => 'Ginny', 'attacks' => ['Coup d\'hélice', 'Charge', 'Réfléxion solaire'],
            'img' => 'build/images/game/Ginnyx600.jpg'
        ];
        $gifAttacks = [
            'camera.gif' => 'Coup de caméra',
            'roll.gif' => 'Rouler',
            'net.gif' => 'Lanceur de filet',
            'helix.gif' => 'Coup d\'hélice',
            'charge.gif' => 'Charge',
            'solar.gif' => 'Réfléxion solaire'
        ];

        $robotCitationsAll = [
            '"Je te filerai de la pommade !" Citation de Percy, le chouchou de la NASA.'
            => 'Coup de caméra',
            '"Tu feras gaffe, je passe !" Citation de Percy, le chouchou de la NASA.'
            => 'Rouler',
            '"Si seulement tes hélices étaient plus coupantes !" Citation de Percy, le chouchou de la NASA.'
            => 'Lanceur de filet',
            '"La bise frérot" Citation de Ginny, aérobot hélicoptère de génie.'
            => 'Coup d\'hélice',
            '"Et oué, je vise les genoux !" Citation de Ginny, aérobot hélicoptère de génie.'
            => 'Charge',
            '"Pense à tes Ray-Ban la prochaine fois !" Citation de Ginny, aérobot hélicoptère de génie.'
            => 'Réfléxion solaire'
        ];

        $attackPercy = $robotPercy['attacks'][rand(0, 2)];
        $attackGinny = $robotGinny['attacks'][rand(0, 2)];
        $attackPercyImg = array_search($attackPercy, $gifAttacks);
        $attackGinnyImg = array_search($attackGinny, $gifAttacks);
        $percyCitations = array_search($attackPercy, $robotCitationsAll);
        $ginnyCitations = array_search($attackGinny, $robotCitationsAll);

        $ginny = [
            'name' => 'Ginny', 'attack' => $attackGinny, 'img' => 'build/images/weapons/' . $attackGinnyImg,
            'citation' => $ginnyCitations
        ];
        $percy = [
            'name' => 'Percy', 'attack' => $attackPercy, 'img' => 'build/images/weapons/' . $attackPercyImg,
            'citation' => $percyCitations
        ];

        if ($attackGinny === 'Réfléxion solaire' && $attackPercy === 'Coup de caméra') {
            $robotWin = $ginny;
            $robotLose = $percy;
        } elseif ($attackGinny === 'Charge' && $attackPercy === 'Rouler') {
            $robotWin = $ginny;
            $robotLose = $percy;
        } elseif ($attackGinny === 'Coup d\'hélice' && $attackPercy === 'Lanceur de filet') {
            $robotWin = $ginny;
            $robotLose = $percy;
        } else {
            $robotWin = $percy;
            $robotLose = $ginny;
        }

        if ($robotSelected === $robotWin['name']) {
            $userWinOrNot = 'Vous avez gagné !';
        } else {
            $userWinOrNot = 'Vous avez misé sur la mauvaise conserve. Essayez encore !';
        }

        $key = 'Uhb88PepnBJsmemDorgenrrjO1qUIovFepIVw5bR';
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://mars-photos.herokuapp.com/api/v1/rovers/Perseverance/photos?earth_date=2021-05-09?api_key=' . $key);
        $statusCode = $response->getStatusCode();
        $maps = ['photos'];

        if ($statusCode === 200) {
            $maps = $response->toArray();
        }
        $maps = [
            $maps['photos']['33'], $maps['photos']['265'], $maps['photos']['203'],  $maps['photos']['269'],
            $maps['photos']['103'], $maps['photos']['5'], $maps['photos']['77'], $maps['photos']['56']
        ];
        $map =  $maps[rand(0, 7)];
        return $this->render('Game/gameWinner.html.twig', [
            'robotWin' => $robotWin,
            'robotLose' => $robotLose,
            'userWinOrNot' => $userWinOrNot,
            'maps' => $map,
            'robotSelecteds' => $robotSelected,
        ]);
    }
}
