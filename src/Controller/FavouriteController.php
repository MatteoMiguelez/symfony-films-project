<?php

namespace App\Controller;

use App\Factory\FavouriteFactory;
use App\Service\apiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorite')]
class FavouriteController extends AbstractController
{
    #[Route('/movie/{id}', name: "manage_favorite_movie")]
    public function manageFavouriteMovie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteMovieIds = FavouriteFactory::getFavouriteMoviesIds($entityManager);

        if (in_array($id, $favouriteMovieIds)){
            FavouriteFactory::deleteFavourite($entityManager, $id, null);
        }else{
            FavouriteFactory::addFavourite($entityManager, $id, null, $this->getUser());
        }
        return $this->redirectToRoute('getMovies');
    }

    #[Route('/serie/{id}', name: "manage_favorite_serie")]
    public function manageFavouriteSerie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteSerieIds = FavouriteFactory::getFavouriteSeriesIds($entityManager);

        if (in_array($id, $favouriteSerieIds)){
            FavouriteFactory::deleteFavourite($entityManager, null, $id);
        }else{
            FavouriteFactory::addFavourite($entityManager, null, $id, $this->getUser());
        }
        return $this->redirectToRoute('getSeries');
    }

    #[Route('/deleteFavMovie/{id}', name: "delete_favorite_movie")]
    public function deleteFavouriteMovie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteMovieIds = FavouriteFactory::getFavouriteMoviesIds($entityManager);

        if (in_array($id, $favouriteMovieIds)){
            FavouriteFactory::deleteFavourite($entityManager, $id, null);
        }
        return $this->redirectToRoute('favourites_list');
    }

    #[Route('/deleteFavSerie/{id}', name: "delete_favorite_serie")]
    public function deleteFavouriteSerie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteSerieIds = FavouriteFactory::getFavouriteSeriesIds($entityManager);

        if (in_array($id, $favouriteSerieIds)){
            FavouriteFactory::deleteFavourite($entityManager, null, $id);
        }
        return $this->redirectToRoute('favourites_list');
    }

    #[Route('', name:'favourites_list')]
    public function getAllFavorites(EntityManagerInterface $entityManager, apiService $apiService): Response
    {
        $favouritesList = FavouriteFactory::getAllFavorites($entityManager, $apiService, $this->getUser());

        return $this->render('favourites.html.twig', [
            'favourites' => $favouritesList,
        ]);
    }
}
