<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Factory\FavouriteFactory;
use App\Factory\MovieFactory;
use App\Service\apiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favourites')]
class FavouriteController extends AbstractController
{
    #[Route('/{id}', name: "manage_favorite")]
    public function manageFavourite(int $id, EntityManagerInterface $entityManager, apiService $apiService){
        $favouriteMovieIds = FavouriteFactory::getFavouriteMoviesIds($entityManager);

        if (in_array($id, $favouriteMovieIds)){
            FavouriteFactory::deleteFavourite($entityManager, $id, null);
        }else{
            FavouriteFactory::addFavourite($entityManager, $id, null);
        }
        return $this->redirect('../movie/all');
    }

    #[Route('', name:'favourites_list')]
    public function getAllFavorites(EntityManagerInterface $entityManager, apiService $apiService): Response
    {
        $favouritesList = FavouriteFactory::getAllFavorites($entityManager, $apiService);

        return $this->render('favourite/favourites.html.twig', [
            'favourites' => $favouritesList,
        ]);
    }
}
