<?php

namespace App\Service;

use App\Entity\Movie;
use App\Entity\Review;
use App\Factory\ActorFactory;
use App\Factory\MovieFactory;
use App\Factory\ReviewFactory;
use App\Factory\WatchProviderFactory;
use Doctrine\ORM\EntityManagerInterface;

class MovieService
{
    public static function getMovieById(int $id, apiService $apiService,  EntityManagerInterface $entityManager):Movie
    {
        $movie = MovieFactory::createMovie($apiService->getMovieById($id));

        /* Credits */
        $credits = $apiService->getFilmCredits($id);

        if (count($credits['cast']) > 18) $credits['cast']= array_splice($credits['cast'], 0, 18);
        foreach ($credits['cast'] as $actorInfos){
            $movie->addActor(ActorFactory::createActor($actorInfos));
        }

        /* Reviews */
        $reviews = $apiService->getMovieReviews($id);
        $localReviews = $entityManager->getRepository(Review::class)->findBy(["movieId" => $id]);

        foreach ($localReviews as $reviewInfos){
            $movie->addReview($reviewInfos);
        }

        foreach ($reviews['results'] as $reviewInfos){
            $movie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        /* Watch Providers */
        $watchProviders = $apiService->getMovieWatchProviders($id);

        if (array_key_exists("FR", $watchProviders["results"]) &&
            array_key_exists('flatrate', $watchProviders["results"]["FR"])){
            foreach ($watchProviders["results"]["FR"]["flatrate"] as $watchProviderInfos){
                $movie->addWatchProvider(WatchProviderFactory::createWatchProvider($watchProviderInfos));
            }
        }

        return $movie;
    }
}