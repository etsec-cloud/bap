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
use Symfony\Component\HttpFoundation\File\File;

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
        $newArticle = new Article();
        $form = $this->createForm(ArticleType::class, $newArticle, ['validation_groups' => ['creation']]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newArticle = $form->getData();

            $image = $form->get('image')->getData();
            $imageName = md5(uniqid()).'.'.$image->guessExtension();
            $image->move($this->getParameter('upload_directory'), $imageName);
            $newArticle->setImage($imageName);

            $newArticle->setBlog(1);
            $newArticle->setCreatedAt(new \DateTime());

            $entityManager->persist($newArticle);
            $entityManager->flush();

            return $this->redirectToRoute('assurance_articles');

        }

        return $this->render('blog-assurance/new.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/remove/{id}", name="removeArticle")
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

    /**
     * @Route("/blog/update/{id}", name="updateArticle")
     */
    public function updateArticle($id, Request $request, EntityManagerInterface $entityManager)
    {
        $article = $this->articleRepository->find($id);

        if($article) {

            $previousImageName = $article->getImage();

            $article->setImage(new File($this->getParameter('upload_directory').'/'.$article->getImage()));
            dump($article->getImage());
            $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();

                if($form->get('image')->getData() !== null) {
                    if($previousImageName) {
                        $article->deleteFileOnUpdate($previousImageName);
                    }

                    $image = $article->getImage();
                    $imageName = md5(uniqid()).'.'.$image->guessExtension();
                    $image->move($this->getParameter('upload_directory'), $imageName);
                    $article->setImage($imageName);
                } else {
                    $article->setImage($previousImageName);
                }

                $entityManager->persist($article);
                $entityManager->flush();

                $this->addFlash('success', "L'article a bien été modifié");
                return $this->redirectToRoute('blogs', ['id', $article->getId()]);
            }

            return $this->render('blog-assurance/new.html.twig', [
                'articleForm' => $form->createView(),
                'article' => $article
            ]);

        } else {
            return $this->redirectToRoute('blogs');
        }
    }
    
}
