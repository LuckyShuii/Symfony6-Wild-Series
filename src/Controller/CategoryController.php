<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategorySelectType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['POST', 'GET'])]
    public function index(Request $request, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategorySelectType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $categoryName = $category->getName();
            return $this->redirectToRoute('category_show', ['categoryName' => $categoryName]);
        }

        return $this->render('category/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/show/', name: 'show', methods: ['GET', 'POST'])]
    public function show(Request $request, CategoryRepository $categoryRepository): Response
    {
        $categoryName = $request->get('category_select')['name'];
        $category = $categoryRepository->findBy(['name' => $categoryName], ['name' => 'DESC'], 3);

        // renvoie une erreur si la category name n'existe pas
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with ' . $categoryName . ' name, found in category\'s table.'
            );
        }

        $programs = $category[0]->getPrograms();

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $category[0],
        ]);
    }
}
