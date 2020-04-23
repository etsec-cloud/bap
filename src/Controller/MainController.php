<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
        ]);
    }

    /**
     * @Route("/assurance-auto", name="AssuranceAuto")
     */
    public function AssuranceAuto()
    {
        return $this->render('main/assurance-auto.html.twig', [
            
        ]);
    }


}
