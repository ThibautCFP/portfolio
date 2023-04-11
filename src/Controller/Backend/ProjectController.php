<?php

namespace App\Controller\Backend;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/projects')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $projectRepository
    ) {
    }
    #[Route('', name: 'app.admin.projects.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Projects/index.html.twig', [
            'projects' => $this->projectRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app.admin.projects.create', methods: ['POST', 'GET'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $project = new Project;
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->save($project, true);

            $this->addFlash('succes', 'Votre project a été ajouté avec succès');

            return $this->redirectToRoute('app.admin.projects.index');
        }

        return $this->render('Backend/Projects/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'app.admin.projects.update', methods: ['POST', 'GET'])]
    public function update(Project $project, Request $request): RedirectResponse|Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectRepository->save($project, true);

            $this->addFlash('success', 'Le projet a bien été modifié');

            return $this->redirectToRoute('app.admin.projects.index');
        }

        return $this->render('Backend/Projects/update.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }

    #[Route('/delete/{id}', name: 'app.admin.projects.delete', methods: ['DELETE', 'POST'])]
    public function delete(Project $project, Request $request): RedirectResponse
    {
        if (!$project instanceof Project) {
            $this->addFlash('error', 'Project non trouvé');

            return $this->redirectToRoute('app.admin.projects.index');
        }

        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->get('_token'))) {
            $this->projectRepository->remove($project, true);

            $this->addFlash('success', 'Le projet a bien été supprimé');

            return $this->redirectToRoute('app.admin.projects.index');
        }

        $this->addFlash('error', 'Token CSRF invalide');

        return $this->redirectToRoute('app.admin.projects.index');
    }
}
