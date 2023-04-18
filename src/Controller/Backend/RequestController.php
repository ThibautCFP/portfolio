<?php

namespace App\Controller\Backend;

use App\Repository\RequestRepository;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/requests')]
class RequestController extends AbstractController
{
    public function __construct(
        private readonly RequestRepository $requestRepository,
        private readonly MessagesRepository $messagesRepository,
    ) {
    }

    #[Route('', name: 'app.admin.requests', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('Backend/Requests/index.html.twig', [
            'requests' => $this->requestRepository->findAll(),
        ]);
    }
}
