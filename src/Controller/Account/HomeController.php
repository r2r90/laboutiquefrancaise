<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }
}
