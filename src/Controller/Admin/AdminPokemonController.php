<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use App\Entity\Pokemon;
use App\Form\BienType;
use App\Form\PokemonType;
use App\Repository\BienRepository;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/admin_pokemon', name: 'app_admin_pokemon')]
class AdminPokemonController extends AbstractController
{

    #[Route('/', name: '_lister')]
    public function lister(PokemonRepository $pokemonRepository): Response
    {
        return $this->render('admin/admin_pokemon/index.html.twig', [
            'pokemonList' => $pokemonRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: '_ajouter')]
    #[Route('/modifier/{id}', name: '_modifier')]
    public function editer(Request $request, EntityManagerInterface $entityManager,PokemonRepository $pokemonRepository, SluggerInterface $slugger, int $id = null): Response
    {
        if($id == null) {
            $pokemon = new Pokemon();
        } else {
            $pokemon = $pokemonRepository->find($id);
        }

        $form = $this->createForm(PokemonType::class,$pokemon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $pokemon->setPrimaryType($form->get('primaryType')->getData());
            if($form->get('secondaryType')->getData() != $form->get('primaryType')->getData()) {
                $pokemon->setSecondaryType($form->get('secondaryType')->getData());
            } else {
                $pokemon->setSecondaryType(null);
            }


            $photoFile = $form->get("photo")->getData();

            // si on uload une image
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photoFile->move(
                        $this->getParameter('pokemons_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $pokemon->setImage($newFilename);
            }

            $entityManager->persist($pokemon);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_pokemon_lister');
        }

        return $this->render('admin/admin_bien/editerBien.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: '_supprimer')]
    public function supprimerPokemon(int $id, PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $pokemon = $pokemonRepository->find($id);
        $entityManager->remove($pokemon);
        $entityManager->flush();

        $this->addFlash('success', 'Le pokemon a été supprimé avec succès.');

        return $this->redirectToRoute('app_admin_pokemon_lister');
    }
}
