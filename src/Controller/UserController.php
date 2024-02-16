<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\WatchList;
use App\Form\BiographyType;
use App\Form\DTO\UserCredentialsDTO;
use App\Form\UserCredentialsType;
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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route('/biography/edit', name: '_biography_edit', methods: ['POST', 'GET'])]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function biographyEdit(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($this->getUser()->getId());
        $form = $this->createForm(BiographyType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/biography_edit_form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/credentials/edit', name: '_credentials_edit', methods: ['POST', 'GET'])]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function credentialsEdit(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $userRepository->find($this->getUser()->getId());

        $form = $this->createForm(UserCredentialsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/credentials_edit_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/favoris/add', name: '_add_favoris', methods: ['POST', 'GET'])]
    #[IsGranted('VOTER_USER', statusCode: 403, message: 'Vous devez être connecté pour accéder à cette page')]
    public function addFavoris(EntityManagerInterface $entityManager, UserRepository $userRepository, ProgramRepository $programRepository, Request $request): Response
    {
        $page = $request->query->get('page');

        $page = match ($page) {
            'program_index' => 'program_index',
            'user_index' => 'app_user',
            default => 'program_index'
        };
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

        return $this->redirectToRoute($page);
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
            'user_index' => 'app_user',
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
