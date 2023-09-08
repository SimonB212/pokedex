<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite')]
    public function favoriteList(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('favorite/favorite.html.twig', [
            'favoriteList' => $pokemonRepository->findBy(['favorite' => true]),
        ]);
    }
}
