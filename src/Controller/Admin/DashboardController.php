<?php

namespace App\Controller\Admin;

use App\Entity\Riddle;
use App\Entity\Score;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(RiddleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CTFOP Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section("Challenges");
        yield MenuItem::linkToCrud('Riddle', 'fas fa-puzzle-piece', Riddle::class);
        yield MenuItem::linkToCrud('Scores', 'fas fa-medal', Score::class);

        yield MenuItem::section("Accounts");
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);

        yield MenuItem::section('Links');
        yield MenuItem::linkToUrl('Home', 'fa fa-home', '/');
    }
}
