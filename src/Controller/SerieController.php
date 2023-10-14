<?php

namespace App\Controller;

use App\Factory\ActorFactory;
use App\Factory\FavouriteFactory;
use App\Factory\ReviewFactory;
use App\Factory\SerieFactory;
use App\Service\apiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('serie')]
class SerieController extends AbstractController
{
    #[Route('/all', name:"getSeries")]
    public function getSeries(apiService $apiService, EntityManagerInterface $entityManager): Response
    {
        $serieList = $apiService->getTopRatedSeries()['results'];
        $favouritesIds = FavouriteFactory::getFavouriteSeriesIds($entityManager);

        $series = [];
        foreach ($serieList as $serieApi){
            $series[] = SerieFactory::createSerie($serieApi, in_array($serieApi['id'], $favouritesIds));
        }

        return $this->render('series.html.twig', [
            'series' => $series
        ]);
    }

    #[Route('/{id}', name:"getSerieById")]
    public function getMovieById(apiService $apiService, array $_route_params): Response
    {
        $serieId= $_route_params['id'];

        $serieApi = $apiService->getSerieById($serieId);
        $credits = $apiService->getSerieCredits($serieId);
        $reviews = $apiService->getSerieReviews($serieId);

        $serie = SerieFactory::createSerieDetailed($serieApi);


        foreach ($credits['cast'] as $actorInfos){
            $serie->addActor(ActorFactory::createActor($actorInfos));
        }

        foreach ($reviews['results'] as $reviewInfos){
            $serie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        return $this->render('serie-details.html.twig', [
            'serie' => $serie
        ]);
    }
}