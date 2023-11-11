<?php

namespace App\Factory;

use App\Entity\Favourite, App\Entity\User;
use App\Service\apiService;
use Doctrine\ORM\EntityManagerInterface;

class FavouriteFactory
{
    public static function getAllFavorites(EntityManagerInterface $entityManager,apiService $apiService, User $user){
        $favourites = $entityManager->getRepository(Favourite::class)->findBy(['user' => $user]);
        $favouritesList = [];

        foreach ($favourites as $favourite){
            if ($favourite->getFilmId()){
                $movie = [1,MovieFactory::createMovie($apiService->getMovieById($favourite->getFilmId()), true)];
                $favouritesList[] = $movie;
            }elseif ($favourite->getSerieId()){
                $serie = [0, SerieFactory::createSerie($apiService->getSerieById($favourite->getSerieId()), true)];
                $favouritesList[] = $serie;
            }
        }
        return $favouritesList;
    }

    public static function getFavouriteMoviesIds(EntityManagerInterface $entityManager, User $user){
        $favouriteList = $entityManager->getRepository(Favourite::class)->findBy(["user" => $user, "serieId" => null]);
        $favouritesIds = [];
        foreach ($favouriteList as $favouriteElement){
            if ($favouriteElement->getFilmId()) {
                $favouritesIds[] = $favouriteElement->getFilmId();
            }
        }
        return $favouritesIds;
    }

    public static function getFavouriteSeriesIds(EntityManagerInterface $entityManager, User $user){
        $favouriteList = $entityManager->getRepository(Favourite::class)->findBy(["user" => $user]);
        $favouritesIds = [];
        foreach ($favouriteList as $favouriteElement){
            if ($favouriteElement->getSerieId()) {
                $favouritesIds[] = $favouriteElement->getSerieId();
            }
        }
        return $favouritesIds;
    }

    public static function addFavourite(EntityManagerInterface $entityManager, ?int $filmId, ?int $serieId, User $user){
        $favourite = new Favourite();
        if ($filmId) $favourite->setFilmId($filmId);
        if ($serieId) $favourite->setSerieId($serieId);
        $favourite->setUser($user);

        $entityManager->persist($favourite);
        $entityManager->flush();
    }

    public static function deleteFavourite(EntityManagerInterface $entityManager, ?int $filmId, ?int $serieId){
        $favourite = null;
        if ($filmId) $favourite = $entityManager->getRepository(Favourite::class)->findOneBy( ['filmId' => $filmId]);
        if ($serieId) $favourite = $entityManager->getRepository(Favourite::class)->findOneBy( ['serieId' => $serieId]);

        if ($favourite){
            $entityManager->remove($favourite);
            $entityManager->flush();
        }
    }
}