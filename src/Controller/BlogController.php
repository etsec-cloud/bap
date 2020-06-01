<?php

namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleType;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blogs", name="blog")
     */
    public function index()
    {
        return $this->render('blog-assurance/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/blog/assurance/article/{id}", name="article")
     */
    public function article(ArticleRepository $articleRepository, $id)
    {
        $article = new Article();
        $article = $articleRepository->findOneById($id);

        return $this->render('blog-assurance/article.html.twig', [
            'article' => $article,
            'articles' => $articleRepository->findLastThree(),
        ]);


    }

    /**
     * @Route("/blog/assurance/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article, ['validation_groups' => ['creation']]);
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

            $article->setBlog(1);
            $article->setCreatedAt(new \DateTime());

            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('blog-assurance/new.html.twig', [
            'article' => $article,
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/assurance", name="article_liste")
     */
    public function liste( ArticleRepository $articleRepository)
    {

        return $this->render('blog-assurance/liste.html.twig', [
            'articles' => $articleRepository->findBlogAssurance(),
        ]);

       
    }

    
}
