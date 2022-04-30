<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    #[Route('/score', name: 'app_score')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ["currentScore" => "DESC"]);
        return $this->render("score/index.html.twig", [
            "users" => $users
        ]);
    }
}
