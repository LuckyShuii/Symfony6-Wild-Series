<?php

namespace App\Controller;

use App\Entity\User;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/', name: '')]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function index(UserRepository $userRepository): Response
    {

        $user = new User();

        $user = $userRepository->find($this->getUser()->getId());
        $watchlists = $user->getWatchLists();

        foreach ($watchlists as $watchlist) {
            $watchlist->getPrograms()->initialize();
        }

        if ($watchlists->isEmpty()) {
            $watchlists = null;
        }

        return $this->render('user/index.html.twig', [
            'watchlists' => $watchlists
        ]);
    }

    #[Route('/favoris/add', name: '_add_favoris', methods: ['POST', 'GET'])]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function addFavoris(EntityManagerInterface $entityManager, UserRepository $userRepository, ProgramRepository $programRepository, Request $request): Response
    {
        /**
         * Si l'entrée dans la table watchlist n'existe pas déjà, on l'ajoute
         */
        $watchlist = new WatchList();
        $watchlist->setUser($userRepository->find($request->query->get('user_id')));

        $program = $programRepository->find($request->query->get('program_id'));
        $watchlist->addProgram($program);

        $watchlist->setLiked(false);
        $watchlist->setSeen(false);

        $entityManager->persist($watchlist);
        $entityManager->flush();

        return $this->redirectToRoute('program_index');
    }

    #[Route('/favoris/remove', name: '_remove_favoris', methods: ['POST', 'GET'])]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function removeFavoris(EntityManagerInterface $entityManager, UserRepository $userRepository, ProgramRepository $programRepository, Request $request, WatchListRepository $watchListRepository): Response
    {
        $user = $userRepository->find($request->query->get('user_id'));
        $program = $programRepository->find($request->query->get('program_id'));
        $page = $request->query->get('page');

        $page = match ($page) {
            'program_index' => 'program_index',
            'user_index' => 'user_index',
            default => 'program_index'
        };

        $watchlists = $watchListRepository->findByUser($user);

        foreach ($watchlists as $watchlist) {
            $watchlist->getPrograms()->initialize();

            if ($watchlist->getPrograms()->contains($program)) {
                $watchlist->removeProgram($program);

                $entityManager->persist($watchlist);
                $entityManager->flush();

                break;
            }
        }

        return $this->redirectToRoute($page);
    }
}
