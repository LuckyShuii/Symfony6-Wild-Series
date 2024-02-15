<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/admin/index', name: 'admin_index')]
    public function adminIndex(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render('program/admin_index.html.twig', [
            'programs' => $programs,
        ]);
    }

    #[Route('/admin/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('program_admin_index');
        }
        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(Program $program, ProgramRepository $programRepository): Response
    {
        // $program = $programRepository->findOneBy(['id' => $id]);
        $program = $programRepository->find($program);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program named : ' . $program . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

    #[Route('/{program_id}/seasons/{season_id}', name: 'season_show')]
    public function showSeason(
        #[MapEntity(mapping: ['program_id' => 'id'])] Program $program,
        #[MapEntity(mapping: ['season_id' => 'id'])] Season $season,
        ProgramRepository $programRepository
    ): Response {
        $oneProgram = $programRepository->findOneBy(['id' => $program]);
        $seasonsArray = [];
        foreach ($oneProgram->getSeasons() as $currentSeason) {
            $seasonsArray[$currentSeason->getId()] = $currentSeason;
        }
        $seasons = $seasonsArray[$season->getId()];

        return $this->render('program/season_show.html.twig', [
            'program' => $oneProgram,
            'season' => $seasons,
        ]);
    }

    #[Route('/{program_id}/seasons/{season_id}/episode/{episode_id}', name: 'episode_show')]
    public function showEpisode(
        #[MapEntity(mapping: ['program_id' => 'id'])] Program $program,
        #[MapEntity(mapping: ['season_id' => 'id'])] Season $season,
        #[MapEntity(mapping: ['episode_id' => 'id'])] Episode $episode,
        ProgramRepository $programRepository
    ): Response {
        $oneProgram = $programRepository->findOneBy(['id' => $program]);
        $seasonsArray = [];
        foreach ($oneProgram->getSeasons() as $currentSeason) {
            $seasonsArray[$currentSeason->getId()] = $currentSeason;
        }
        $seasons = $seasonsArray[$season->getId()];

        // get the current episode
        $currentEpisode = $seasons->getEpisodes();
        $currentEpisode = $currentEpisode->get($episode->getId());

        return $this->render('program/episode_show.html.twig', [
            'program' => $oneProgram,
            'season' => $seasons,
            'episode' => $episode,
        ]);
    }

    #[Route('/admin/edit/{id}', name: 'admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('program_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('program/admin_edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'admin_delete', methods: ['POST'])]
    public function delete(Request $request, Program $program, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $entityManager->remove($program);
            $entityManager->flush();
        }

        return $this->redirectToRoute('program_admin_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/admin/show/{id}', name: 'admin_show', methods: ['GET'])]
    public function adminShow(Program $program): Response
    {
        return $this->render('program/admin_show.html.twig', [
            'program' => $program,
        ]);
    }
}
