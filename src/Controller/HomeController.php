<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pokemon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'pokemonList' => $pokemonRepository->findAll(),
        ]);
    }

    #[Route('/updateFavorite/{id}', name: 'update_favorite')]
    public function updateFavorite(EntityManagerInterface $entityManager, PokemonRepository $pokemonRepository, int $id = null): JsonResponse
    {
        $pokemon = $pokemonRepository->find($id);
        $pokemon->setFavorite(!$pokemon->isFavorite());

        $entityManager->persist($pokemon);
        $entityManager->flush();

        // You can return the updated favorite status in the response
        return new JsonResponse(['success' => true]);
    }
}