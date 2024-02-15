<?php

namespace App\Controller;

use App\Entity\WatchList;
use App\Repository\ProgramRepository;
use App\Repository\UserRepository;
use App\Repository\WatchListRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/favoris/add', name: '_add_favoris', methods: ['POST', 'GET'])]
    public function addFavoris(EntityManagerInterface $entityManager, UserRepository $userRepository, ProgramRepository $programRepository, Request $request): Response
    {
        /**
         * Si l'entrée dans la table watchlist n'existe pas déjà, on l'ajoute
         */
        $watchlist = new WatchList();
        $watchlist->setUser($userRepository->find($request->query->get('user_id')));
        $watchlist->setProgram($programRepository->find($request->query->get('program_id')));
        $watchlist->setLiked(false);
        $watchlist->setSeen(false);

        $entityManager->persist($watchlist);
        $entityManager->flush();

        return $this->redirectToRoute('program_index');
    }
}
