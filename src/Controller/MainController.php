<?php

namespace App\Controller;

use App\Form\AssuranceType;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
        ]);
    }

    /**
     * @Route("/secteur-particulier" , name="SecteurParticulier")
     */

    public function SecteurParticulier()
    {


        return $this->render('main/secteur-particulier.html.twig', [
        ]);
    }



    /**
     * @Route("/assurance-auto", name="AssuranceAuto")
     */
    public function AssuranceAuto(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('tel')) ? $form->get('tel')->getData() : null;
            $message = $form->get('message')->getData();

            $document = $request->files->get('assurance')['documents'][0];

            $documentName = md5(uniqid()).'.'.$document->guessExtension();
            $document = $document->move($this->getParameter('upload_documents'), $documentName);

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-auto')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ])
            ->attachFromPath($document->getPathName());
            ;

            $mailer->send($sendEmail);

            unlink(__DIR__ . '/../../public/uploads/documents/'.$documentName);
        }

        return $this->render('main/assurance-auto.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }


}
