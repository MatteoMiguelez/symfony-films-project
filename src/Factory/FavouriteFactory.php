<?php

namespace App\Factory;

use App\Entity\Favourite;
use App\Service\apiService;
use Doctrine\ORM\EntityManagerInterface;

class FavouriteFactory
{
    public static function getAllFavorites(EntityManagerInterface $entityManager,apiService $apiService){
        $favourites = $entityManager->getRepository(Favourite::class)->findAll();
        $favouritesList = [];

        foreach ($favourites as $favourite){
            if ($favourite->getFilmId()){
                $movie = MovieFactory::createMovie($apiService->getMovieById($favourite->getFilmId()), true);
                $favouritesList[] = $movie;
            }elseif ($favourite->getSerieId()){

            }
        }
        return $favouritesList;
    }

    public static function getFavouriteMoviesIds(EntityManagerInterface $entityManager){
        $favouriteList = $entityManager->getRepository(Favourite::class)->findAll();
        $favouritesIds = [];
        foreach ($favouriteList as $favouriteElement){
            if ($favouriteElement->getFilmId()) {
                $favouritesIds[] = $favouriteElement->getFilmId();
            }
        }
        return $favouritesIds;
    }

    public static function getFavouriteSeriesIds(EntityManagerInterface $entityManager){
        $favouriteList = $entityManager->getRepository(Favourite::class)->findAll();
        $favouritesIds = [];
        foreach ($favouriteList as $favouriteElement){
            if ($favouriteElement->getSerieId()) {
                $favouritesIds[] = $favouriteElement->getSerieId();
            }
        }
        return $favouritesIds;
    }

    public static function addFavourite(EntityManagerInterface $entityManager, ?int $filmId, ?int $serieId){
        $favourite = new Favourite();
        if ($filmId) $favourite->setFilmId($filmId);
        if ($serieId) $favourite->setSerieId($serieId);

        $entityManager->persist($favourite);
        $entityManager->flush();
    }

    public static function deleteFavourite(EntityManagerInterface $entityManager, ?int $filmId, ?int $serieId){
        $favourite = null;
        if ($filmId) $favourite = $entityManager->getRepository(Favourite::class)->findOneBy( ['filmId' => $filmId]);
        if ($serieId) $favourite = $entityManager->getRepository(Favourite::class)->findOneBy( ['serieId' => $filmId]);

        $entityManager->remove($favourite);
        $entityManager->flush();
    }
}