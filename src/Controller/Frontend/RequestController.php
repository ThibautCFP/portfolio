<?php

namespace App\Controller\Frontend;

use App\Entity\Messages;
use App\Entity\Request;
use App\Form\MessageType;
use App\Form\RequestType;
use App\Repository\RequestRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as Req;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/requests')]
class RequestController extends AbstractController
{
    public function __construct(
        private readonly RequestRepository $requestRepository,
        private readonly MessagesRepository $messagesRepository,
    ) {
    }

    #[Route('', name: 'app.requests', methods: ['GET'])]
    public function index(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        return $this->render('Frontend/Requests/index.html.twig', [
            'requests' => $user ? $this->requestRepository->findRequestsByUserId($user->getId()) : '',
        ]);
    }

    #[Route('/create', name: 'app.requests.create', methods: ['POST', 'GET'])]
    public function create(Req $req): Response|RedirectResponse
    {
        if ($this->getUser()) {
            $request = new Request();
            $form = $this->createForm(RequestType::class, $request);

            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $request->setAuthor($this->getUser());
                $request->getMessages()[0]->setAuthor($this->getUser());
                $request->getMessages()[0]->setSupport(false);

                $this->requestRepository->save($request, true);

                $this->addFlash('success', 'La demande a bien été enregistrée');

                return $this->redirectToRoute('app.requests');
            }

            return $this->render('Frontend/Requests/create.html.twig', [
                'form' => $form
            ]);
        } else {
            $this->addFlash('error', 'Vous devez être connecter pour envoyer une demande');

            return $this->redirectToRoute('app.requests');
        }
    }

    #[Route('/show/{id}', name: 'app.requests.show', methods: ['GET', 'POST'])]
    public function response(Request $request, Req $req): Response|RedirectResponse
    {
        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setRequest($request);
            $message->setAuthor($this->getUser());
            if ($req->attributes->get('_route') == 'app.admin.requests.show') {
                $message->setSupport(true);
            } else {
                $message->setSupport(false);
            }

            $this->messagesRepository->save($message, true);

            $this->addFlash('success', 'Message ajouté avec succès');

            return $this->redirectToRoute('app.requests.show', [
                'id' => $request->getId(),
            ]);
        }
        return $this->render('Frontend/Requests/show.html.twig', [
            'form' => $form->createView(),
            'request' => $request,
            'messages' => $this->messagesRepository->findMessagesByIdWithUser($request->getId()),
        ]);
    }
}
