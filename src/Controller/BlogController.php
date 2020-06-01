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

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/blogs", name="blogs")
     */
    public function index()
    {
        return $this->render('blog-assurance/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/blog/assurance/article/{id}", name="assurance_article")
     */
    public function article($id)
    {
        $article = new Article();
        $article = $this->articleRepository->findOneById($id);

        $articles = $this->articleRepository->findLastThree();

        return $this->render('blog-assurance/article.html.twig', [
            'article' => $article,
            'articles' => $articles,
        ]);


    }

    /**
     * @Route("/blog/assurance/new", name="assurance_newArticle", methods={"GET","POST"})
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

            return $this->redirectToRoute('assurance_articles');
        }

        return $this->render('blog-assurance/new.html.twig', [
            'article' => $article,
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/assurance", name="assurance_articles")
     */
    public function liste()
    {
        $articles = $this->articleRepository->findBlogAssurance();

        return $this->render('blog-assurance/liste.html.twig', [
            'articles' => $articles,
        ]);

       
    }

    /**
     * @Route("/blog/remove/{id}"), name="removeArticle")
     */
    public function removeArticle($id, EntityManagerInterface $entityManager)
    {
        $article = $this->articleRepository->find($id);

        if($article) {

            $article->deleteFile();

            $entityManager->remove($article);
            $entityManager->flush();

            $this->addFlash('success', "L'article a bien été supprimé !");
            return $this->redirectToRoute('blogs');

        } else {
            $this->addFlash('error', "L'article n'a pas été trouvé");
            return $this->redirectToRoute('blogs');
        }
    }

    
}
