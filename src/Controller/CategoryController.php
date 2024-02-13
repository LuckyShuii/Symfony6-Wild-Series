<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'website' => 'Wild Series',
            'categories' => $categories,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository): Response
    {
        // Si une catégorie existe, cette méthode récupère toutes les séries présentes en base de données qui appartiennent à cette catégorie. 

        if (!$categoryName) {
            throw $this->createNotFoundException('No category has been sent to find a program in category\'s table.');
        }

        $category = $categoryRepository->findBy(['name' => $categoryName], ['id' => 'DESC'], 3);

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
