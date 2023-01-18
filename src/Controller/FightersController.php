<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FightersController extends AbstractController
{
    /**
     * @Route("/fighter", name="fighters")
     */
    public function index(): Response
    {
        return $this->render('Fighters/index.html.twig');
    }
}
