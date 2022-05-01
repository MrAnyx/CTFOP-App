<?php

namespace App\Controller;

use App\Repository\RiddleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(RiddleRepository $riddleRepository): Response
    {
        $riddle = $riddleRepository->findOneBy([], ["createdAt" => "DESC"]);

        return $this->render('home/index.html.twig', [
            'lastRiddle' => $riddle,
        ]);
    }
}
