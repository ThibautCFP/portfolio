<?php

namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'app.front.home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/index.html.twig');
    }
}
