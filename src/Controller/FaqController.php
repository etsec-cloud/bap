<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
     /**
     * @Route("/faq", name="faq")
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {
        $newQuestion = new Question();
        $form = $this->createForm(QuestionType::class, $newQuestion);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $newQuestion = $form->getData();
            $newQuestion->setUser($user);

            $entityManager->persist($newQuestion);
            $entityManager->flush();

            return $this->redirectToRoute('faq');
        }

        return $this->render('faq/index.html.twig', [
            'questionForm' => $form->createView()
        ]);
    }
}
