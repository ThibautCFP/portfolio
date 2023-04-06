<?php

namespace App\Controller\Backend;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/projects')]
class ProjectController extends AbstractController
{
    #[Route('', name: 'app.admin.projects', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('Backend/Projects/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
