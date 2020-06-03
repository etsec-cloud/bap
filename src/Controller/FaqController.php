<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Form\SearchType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FaqController extends AbstractController
{
     /**
     * @Route("/faq", name="faq")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, QuestionRepository $questionRepository, $content=null)
    {
        $newQuestion = new Question();
        $questionForm = $this->createForm(QuestionType::class, $newQuestion);
        $questionForm->handleRequest($request);

        if($questionForm->isSubmitted() && $questionForm->isValid()) {

            $user = $this->getUser();

            $newQuestion = $questionForm->getData();
            $newQuestion->setUser($user);

            $entityManager->persist($newQuestion);
            $entityManager->flush();

            return $this->redirectToRoute('faq');
        }

        $questions = $questionRepository->findAll();

        $questionSearch = $this->createForm(SearchType::class,);
        $questionsFound = $questionRepository->SearchBar($content);

        return $this->render('faq/index.html.twig', [
            'questionForm' => $questionForm->createView(),
            'questions' => $questions,

            'questionSearch' => $questionSearch->createView(),
            'questionsFound' => $questionsFound,
            
        ]);
    }



    /**
     * @Route("faq/give-response/{id}", name="give-response")
     */
    public function giveResponse($id, Request $request, EntityManagerInterface $entityManager, QuestionRepository $questionRepository)
    {
        if(isset($_POST['submitResponse']) && isset($id)) {

            if(!empty($_POST['response'])) {

                $question = $questionRepository->find($id);

                if($question) {
                    $response = $request->request->get('response');
                    $question->setResponse($response);

                    $entityManager->persist($question);
                    $entityManager->flush();
                }

            }

        }

        return $this->redirectToRoute('faq');
    }


     

}
