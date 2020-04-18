<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

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
    public function AssuranceAuto(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('test@agence.fr')
            ->to('contact@agence.fr')
            ->subject('Test')
            ->text('Ceci est un test')
            ->html("<b>test de HTML<b>");

        $mailer->send($email);

        return $this->render('main/assurance-auto.html.twig', [
            
        ]);
    }

}
