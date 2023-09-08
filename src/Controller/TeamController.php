<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/team', name: 'app_team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_liste')]
    public function liste(): Response
    {


        return $this->render('teams/teamsList.html.twig', [
            'controller_name' => 'TeamController',
        ]);
    }
}
