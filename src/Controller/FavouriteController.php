<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Factory\FavouriteFactory;
use App\Service\apiService;
use App\Service\FavouriteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorite')]
class FavouriteController extends AbstractController
{
    #[Route('/movie/{id}', name: "manage_favorite_movie")]
    public function manageFavouriteMovie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteMovieIds = FavouriteService::getFavouriteMoviesIds($entityManager, $this->getUser());

        if (in_array($id, $favouriteMovieIds)){
            FavouriteService::deleteFavourite($entityManager, $id, null);
        }else{
            FavouriteService::addFavourite($entityManager, $id, null, $this->getUser());
        }
        return $this->redirectToRoute('getMovies');
    }

    #[Route('/serie/{id}', name: "manage_favorite_serie")]
    public function manageFavouriteSerie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteSerieIds = FavouriteService::getFavouriteSeriesIds($entityManager, $this->getUser());

        if (in_array($id, $favouriteSerieIds)){
            FavouriteService::deleteFavourite($entityManager, null, $id);
        }else{
            FavouriteService::addFavourite($entityManager, null, $id, $this->getUser());
        }
        return $this->redirectToRoute('getSeries');
    }

    #[Route('/deleteFavMovie/{id}', name: "delete_favorite_movie")]
    public function deleteFavouriteMovie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteMovieIds = FavouriteService::getFavouriteMoviesIds($entityManager, $this->getUser());

        if (in_array($id, $favouriteMovieIds)){
            FavouriteService::deleteFavourite($entityManager, $id, null);
        }
        return $this->redirectToRoute('favourites_list');
    }

    #[Route('/deleteFavSerie/{id}', name: "delete_favorite_serie")]
    public function deleteFavouriteSerie(int $id, EntityManagerInterface $entityManager): Response{
        $favouriteSerieIds = FavouriteService::getFavouriteSeriesIds($entityManager, $this->getUser());

        if (in_array($id, $favouriteSerieIds)){
            FavouriteService::deleteFavourite($entityManager, null, $id);
        }
        return $this->redirectToRoute('favourites_list');
    }

    #[Route('', name:'favourites_list')]
    public function getAllFavorites(EntityManagerInterface $entityManager, apiService $apiService): Response
    {
        $favouritesList = FavouriteService::getAllFavorites($entityManager, $apiService, $this->getUser());

        return $this->render('favourites.html.twig', [
            'favourites' => $favouritesList,
        ]);
    }
}
