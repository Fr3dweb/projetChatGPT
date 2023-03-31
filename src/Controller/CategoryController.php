<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/new', name: 'app_category_new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && ($form->isValid())) {
            $categoryRepository->save($category, true);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route ('/category/show', name: "app_category_show")]
    public function show(CategoryRepository $categoryRepository, $id): Response
    {
        $category = $categoryRepository->find($id);


        return $this->render('category/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_waiting', methods: ['get'])]
    public function waiting(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        $articles = $category->getArticles()->filter(function ($article) {
            return $article->getStatus() === null;
        });

        return $this->render('sub_category/waiting.html.twig', [
            'category' => $categoryRepository,
            'articles' => $articles
        ]);
    }
}
