<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\GenerateArticleType;
use App\Service\OpenAIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(Request $request,EntityManagerInterface $entityManager, OpenAIService $openAI): Response
    {
        $form = $this->createForm(GenerateArticleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && ($form->isValid())) {
            $data = $form->getData();
            $json = $openAI->getInputArticle($data['article']);

            // On crée une nouvelle instance de l'entité Article
            $article = new Article();
            $article->setTitle($data['title']);
            $article->setContent($data['content']);

            // On récupère la catégorie associée à l'article (par exemple, en la cherchant par son nom)
            $category = $form->get('category')->getData();

            // On lie l'article à la catégorie
            $article->setCategory($category);

            // On enregistre l'article en base de données
            $entityManager->persist($article);
            $entityManager->flush();


            return $this->render('chatGPT/ArticleGenerate.html.twig', [
                'json' => $data,
            ]);
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
