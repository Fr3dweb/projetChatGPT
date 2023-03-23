<?php

namespace App\Controller;

use App\Form\GenerateArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(GenerateArticleType::class);
        $form->handleRequest($request);

        return $this->render('home/index.html.twig', [

        ]);
    }
}
