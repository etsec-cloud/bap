<?php

namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/article/show/{id}", name="article")
     */
    public function article($id)
    {
        $article = new Article();
        $em = $this -> getDoctrine() -> getManager();
        $article = $em->getRepository(Article::class)->findOneById($id);

        return $this->render('blog/article.html.twig', [
            'article' => $article,
        ]);


    }

    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichier = $form->get('image')->getData();

            if ($fichier) {
                $newFilename = uniqid().'.'.$fichier->guessExtension();

                try {
                    $fichier->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', "Impossible d'uploader le fichier");
                }

                $article->setImage($newFilename);
            }

            $article->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('blog/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/liste", name="article_liste")
     */
    public function liste( )
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article::class)->findAll();

        return $this->render('blog/liste.html.twig', [
            'articles' => $articles
        ]);

       
    }


    /**
     * @Route("/faq", name="FAQ")
     */
    public function FAQ(){
        return $this->render('blog/faq.html.twig', [
            
        ]);
    }

    
}
