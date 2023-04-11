<?php

namespace App\Controller\Backend;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/skills')]
class SkillController extends AbstractController
{
    public function __construct(private readonly SkillRepository $skillRepository)
    {
    }
    #[Route('', name: 'app.admin.skills.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Skills/index.html.twig', [
            'skills' => $this->skillRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'app.admin.skills.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $skill = new Skill;
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->skillRepository->save($skill, true);

            $this->addFlash('success', 'La compétence a bien été créée');

            return $this->redirectToRoute('app.admin.skills.index');
        }

        return $this->render('Backend/Skills/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'app.admin.skills.update', methods: ['GET', 'POST'])]
    public function update(Skill $skill, Request $request): Response|RedirectResponse
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->skillRepository->save($skill, true);

            $this->addFlash('success', 'Compétence modifiée avec succès');

            return $this->redirectToRoute('app.admin.skills.index');
        }

        return $this->render('Backend/Skills/update.html.twig', [
            'form' => $form,
            'skill' => $skill,
        ]);
    }

    #[Route('/delete/{id}', name: 'app.admin.skills.delete', methods: ['POST', 'DELETE'])]
    public function delete(Skill $skill, Request $request): RedirectResponse
    {
        if (!$skill instanceof Skill) {
            $this->addFlash('error', 'Compétenec non trouvée');

            return $this->redirectToRoute('app.admin.skills.index');
        }

        if ($this->isCsrfTokenValid('delete' . $skill->getId(), $request->get('_token'))) {
            $this->skillRepository->remove($skill, true);

            $this->addFlash('success', 'La compétence a été supprimée avec succès');

            return $this->redirectToRoute('app.admin.skills.index');
        }

        $this->addFlash('error', 'Token CSRF invalide');

        return $this->redirectToRoute('app.admin.skills.index');
    }
}
