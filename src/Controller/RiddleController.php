<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RiddleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RiddleController extends AbstractController
{
    #[Route('/riddles', name: 'app_riddles')]
    public function index(RiddleRepository $riddlesRepository): Response
    {
        $riddles = $riddlesRepository->findBy([], ["createdAt" => "DESC"]);
        return $this->render("riddle/index.html.twig", [
            "riddles" => $riddles
        ]);
    }
}
