<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WeaponsController extends AbstractController
{
    /**
     * @Route("/weapons", name="weapons")
     */
    public function index()
    {
        return $this->render('Weapons/weapons.html.twig');
    }
}
