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

    public static function addFavourite(EntityManagerInterface $entityManager, int $id){
        $favourite = $entityManager->getRepository(Favourite::class)->findOneBy( ['filmId' => $id]);

        $entityManager->remove($favourite);
        $entityManager->flush();
    }

    public static function deleteFavourite(EntityManagerInterface $entityManager, int $id){
        $favourite = new Favourite();
        $favourite->setFilmId($id);

        $entityManager->persist($favourite);
        $entityManager->flush();
    }
}