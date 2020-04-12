<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
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
