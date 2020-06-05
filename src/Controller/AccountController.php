<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/update-account", name="update-account")
     */
    public function updateAccount(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $previousImageName = $user->getImage();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $verifypassword = $request->request->get('verifypassword');
            if ($passwordEncoder->isPasswordValid($user, $verifypassword, $user->getSalt())) {

                $user = $form->getData();

                if($form->get('plainPassword')->getData() !== null) {
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
                }

                if($form->get('image')->getData() !== null) {

                    if($previousImageName) {
                        $user->deleteFileOnUpdate($previousImageName);
                    }

                    $image = $form->get('image')->getData();
                    $imageName = md5(uniqid()).'.'.$image->guessExtension();
                    $image->move($this->getParameter('upload_directory'), $imageName);
                    $user->setImage($imageName);

                } else {
                    if($previousImageName) {
                        $user->setImage($previousImageName);
                    }
                }

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', "Vos informations ont bien été modifié");
                return $this->redirectToRoute('account');

            } else {
                $this->addFlash('error', "Mot de passe incorrect");
                return $this->redirectToRoute('update-account');
            }
        }

        return $this->render('account/update.html.twig', [
            'user' => $user,
            'registrationForm' => $form->createView()
        ]);
    }

}
