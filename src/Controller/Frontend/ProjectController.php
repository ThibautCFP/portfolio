<?php

namespace App\Controller\Frontend;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/projects')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository,
    ) {
    }

    #[Route('', name: 'app.projects', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/Projects/index.html.twig', [
            'projects' => $this->projectRepository->findWithSkills(),
        ]);
    }

    #[Route('/show/{id}', name: 'app.projects.show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('Frontend/Projects/show.html.twig', [
            'project' => $project,
            'images' => $project->getImages(),
            'skills' => $project->getSkills(),
        ]);
    }
}
