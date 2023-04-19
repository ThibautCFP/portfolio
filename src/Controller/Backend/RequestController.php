<?php

namespace App\Controller\Backend;

use App\Entity\Request;
use App\Entity\Messages;
use App\Form\MessageType;
use App\Repository\RequestRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as req;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/requests')]
class RequestController extends AbstractController
{
    public function __construct(
        private readonly RequestRepository $requestRepository,
        private readonly MessagesRepository $messagesRepository,
    ) {
    }

    #[Route('', name: 'app.admin.requests', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Backend/Requests/index.html.twig', [
            'requests' => $this->requestRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app.admin.requests.show', methods: ['GET', 'POST'])]
    public function show(Request $request, req $req): Response|RedirectResponse
    {
        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuthor($this->getUser());
            $message->setRequest($request);
            if ($req->attributes->get('_route') == 'app.admin.requests.show') {
                $message->setSupport(true);
            } else {
                $message->setSupport(false);
            }

            $this->messagesRepository->save($message, true);

            $this->addFlash('success', 'Message ajouté avec succès');

            return $this->redirectToRoute('app.admin.requests.show', [
                'id' => $request->getId(),
            ]);
        }

        return $this->render('Backend/Requests/show.html.twig', [
            'request' => $request,
            'messages' => $request->getMessages(),
            'form' => $form->createView(),
        ]);
    }
}
