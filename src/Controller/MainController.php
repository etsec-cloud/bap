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

            $documentNames = [];
            $documents = $request->files->get('assurance')['documents'];

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
            ]);

            foreach($documents as $document) {
                $originalName = $document->getClientOriginalName();
                $documentName = md5(uniqid()).'.'.$document->guessExtension();
                $documentNames[] = $documentName;
                $document = $document->move($this->getParameter('upload_documents'), $documentName);
                $sendEmail->attachFromPath($document->getPathName(), $originalName);
            }

            $mailer->send($sendEmail);

            foreach($documentNames as $document) {  
                unlink(__DIR__ . '/../../public/uploads/documents/'.$document);
            }
        }

        return $this->render('main/particuliers/assurance-auto.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/assurance-23roues", name="Assurance23Roues")
     */
    public function Assurance23Roues(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-23Roues')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-23roues.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/assurance-habitation", name="AssuranceHabitation")
     */
    public function AssuranceHabitation(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-Habitation')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-habitation.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    
    /**
     * @Route("/assurance-retaite", name="AssuranceRetraite")
     */
    public function AssuranceRetraite(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-Retraite')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-retraite.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/assurance-pretparticulier", name="AssurancePretParticulier")
     */
    public function AssurancePretParticulier(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-PretParticulier')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-pret-particulier.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/assurance-prevoyance", name="AssurancePrevoyance")
     */
    public function AssurancePrevoyance(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-PretParticulier')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-prevoyance.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/assurance-produits", name="AssuranceProduits")
     */
    public function AssuranceProduits(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-PretParticulier')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-produits.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/assurance-sante-particuliers", name="AssuranceComplementaireSante")
     */
    public function AssuranceComplementaireSante(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance-ComplementaireSante')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-complementaire-sante.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/assurance-animaux-compagnie", name="AssuranceAnimauxCompagnie")
     */
    public function AssuranceAnimauxCompagnie(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance pour les animaux de compagnie')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/animaux-compagnie.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/assurance-protection-juridique", name="AssuranceProtectionJuridique")
     */
    public function AssuranceProtectionJuriqique(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance pour la protection juridique')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/protection-juridique.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/assurance-voyage", name="AssuranceVoyage")
     */
    public function AssuranceVoyage(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance pour vos voyages')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/particuliers/assurance-voyage.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/secteur-liberales-artisans-commercants" , name="SecteurLiberaleArtisansCommercants")
     */

    public function SecteurLiberaleArtisansCommercants()
    {

        return $this->render('main/secteur-liberales-artisans-commercants.html.twig', [
        ]);
    }

    /**
     * @Route("/femme-homme-cle", name="femmeHommeCle")
     */
    public function femmeHommeCle(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Femme & Homme Clé')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/femme-homme-cle.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/locaux-professionnels", name="locauxProfessionnels")
     */
    public function locauxProfessionnels(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Locaux professionnels')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/locaux-professionnels.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/prevoyance-madelin", name="provoyanceMadelin")
     */
    public function prevoyanceMadelin(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Prévoyance madelin')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/prevoyance-madelin.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/responsabilite-civile", name="responsabiliteCivile")
     */
    public function responsabiliteCivile(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Responsabilité civile')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/responsabilite-civile.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/retraite-madelin", name="retraiteMadelin")
    */
    public function retraiteMadelin(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Retraite madelin')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/retraite-madelin.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/sante-madelin", name="santeMadelin")
    */
    public function santeMadelin(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Santé madelin')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/sante-madelin.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

        /**
     * @Route("/secteur-entreprise" , name="SecteurEntreprise")
     */

    public function SecteurEntreprise()
    {
        return $this->render('main/secteur-entreprise.html.twig', [
        ]);
    }

    /**
     * @Route("/assurance-pret", name="assurancePret")
     */
    public function assurancePret(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance prêt')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/assurance-pret.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

        /**
     * @Route("/flottes-auto-moto", name="flotteAutoMoto")
     */
    public function flotteAutoMoto(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Flotte auto/moto')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/flottes-auto-moto.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/perco-pee", name="PercoPee")
     */
    public function PercoPee(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Perco & Pee')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/perco-pee.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
    /**
     * @Route("/retraite-collective", name="retraiteCollective")
     */
    public function retraiteCollective(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Retraite collective')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/retraite-collective.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/sante-collective", name="santeCollective")
     */
    public function santeCollective(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Santé collective')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/sante-collective.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/cyber-assurance", name="cyberAssurance")
     */
    public function cyberAssurance(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Cyber assurance')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/cyber-assurance.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/protection-juridique-fiscale", name="protectionJuridiqueFiscale")
     */
    public function protectionJuridiqueFiscale(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Protection juridique et fiscale')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/entreprises/protection-juridique-fiscale.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }

        /**
     * @Route("/assurance-laverie", name="assuranceLaverie")
     */
    public function assuranceLaverie(MailerInterface $mailer, Request $request)
    {
        $form = $this->createForm(AssuranceType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $phone = ($form->get('phone')) ? $form->get('phone')->getData() : null;
            $message = $form->get('message')->getData();

            $sendEmail = (new TemplatedEmail())
            ->from($email)
            ->to('contact@agence.fr')
            ->subject('Demande de devis: Assurance laverie')
            ->text('Ceci est un test')
            ->htmlTemplate('emails/assurance.html.twig')
            ->context([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'phone' => $phone,
                'message' => $message
            ]);

            $mailer->send($sendEmail);
        }

        return $this->render('main/liberales-artisans-commercants/assurance-laverie.html.twig', [
            'assuranceForm' => $form->createView()
        ]);
    }
}