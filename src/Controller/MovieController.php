<?php

namespace App\Controller;

use App\Factory\ActorFactory;
use App\Factory\MovieFactory;
use App\Factory\ReviewFactory;
use App\Factory\ThemeFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\apiService;

#[Route('/movie')]
class MovieController extends AbstractController
{

    #[Route('/all')]
   public function getMovies(apiService $apiService): Response
    {
        $movieList = $apiService->getPopularMovies()['results'];
        $movies = [];
        foreach ($movieList as $movieApi){
            $movies[] = MovieFactory::createMovie($movieApi);
        }

        return $this->render('movies.html.twig', [
            'movies' => $movies
        ]);
    }

     #[Route('/{id}')]
    public function getMovieById(apiService $apiService, array $_route_params): Response
    {
        $filmId= $_route_params['id'];

        $response = $apiService->getMovieById($filmId);
        $credits = $apiService->getFilmCredits($filmId);
        $reviews = $apiService->getMovieReviews($filmId);

        $movie = MovieFactory::createMovie($response);

        foreach ($response['genres'] as $genre){
            $movie->addTheme(ThemeFactory::createTheme($genre));
        }

        foreach ($credits['cast'] as $actorInfos){
            $movie->addActor(ActorFactory::createActor($actorInfos));
        }

        foreach ($reviews['results'] as $reviewInfos){
            $movie->addReview(ReviewFactory::createNotice($reviewInfos));
        }

        return $this->render('movie-details.html.twig', [
            'movie' => $movie
        ]);
    }
}