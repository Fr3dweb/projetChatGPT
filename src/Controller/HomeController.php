<?php

namespace App\Controller;

use App\Form\GenerateArticleType;
use App\Service\OpenAIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, OpenAIService $openAI): Response
    {
        $form = $this->createForm(GenerateArticleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && ($form->isValid())) {
            $data = $form->getData();
            $json = $openAI->getInputArticle($data['article']);

            return $this->render('chatGPT/ArticleGenerate.html.twig', [
                'json' => $json ?? null,
            ]);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
