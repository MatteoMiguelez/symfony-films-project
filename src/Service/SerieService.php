<?php

namespace App\Service;

use App\Entity\Review;
use App\Entity\Serie;
use App\Factory\ActorFactory;
use App\Factory\ReviewFactory;
use App\Factory\SerieFactory;
use App\Factory\WatchProviderFactory;
use Doctrine\ORM\EntityManagerInterface;

class SerieService
{
    public static function getSerieById(int $id, apiService $apiService, EntityManagerInterface $entityManager) : Serie
    {
        $serie = SerieFactory::createSerieDetailed($apiService->getSerieById($id));

        /* Credits */
        $credits = $apiService->getSerieCredits($id);

        if ($credits['cast'] && count($credits['cast']) > 18) {
            $credits['cast']= array_splice($credits['cast'], 0, 18);
        }

        foreach ($credits['cast'] as $actorInfos){
            $serie->addActor(ActorFactory::createActor($actorInfos));
        }

        /* Reviews */
        $reviews = $apiService->getSerieReviews($id);
        $localReviews = $entityManager->getRepository(Review::class)->findBy(["serieId" => $id]);

        foreach ($localReviews as $reviewInfos){
            $serie->addReview($reviewInfos);
        }

        foreach ($reviews['results'] as $reviewInfos){
            $serie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        /* Watch Providers */
        $watchProviders = $apiService->getSerieWatchProviders($id);

        if (array_key_exists("FR", $watchProviders["results"]) && array_key_exists('flatrate', $watchProviders["results"]["FR"])){
            foreach ($watchProviders["results"]["FR"]["flatrate"] as $watchProviderInfos){
                $serie->addWatchProvider(WatchProviderFactory::createWatchProvider($watchProviderInfos));
            }
        }

        return $serie;
    }
}