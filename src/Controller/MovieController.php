<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Review;
use App\Entity\Theme;
use App\Factory\ActorFactory;
use App\Factory\MovieFactory;
use App\Factory\ReviewFactory;
use App\Factory\ThemeFactory;
use App\Kernel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\apiService;
use App\Entity\Movie;

#[Route('/movie')]
class MovieController extends AbstractController
{

    #[Route('/all')]
   public function getMovies(apiService $apiService): Response
    {
        $response = $apiService->callApi('movie/popular');
        $movieList = $response['results'];
        $movies = [];
        foreach ($movieList as $movieApi){
            $movie = MovieFactory::createMovie($movieApi);
            $movies[] = $movie;
        }

        return $this->render('movies.html.twig', [
            'movies' => $movies
        ]);
    }

     #[Route('/{id}')]
    public function getMovieById(apiService $apiService, array $_route_params): Response
    {
        $response = $apiService->callApi('movie/'.$_route_params['id']);
        $movie = MovieFactory::createMovie($response);

        foreach ($response['genres'] as $genre){
            $theme = ThemeFactory::createTheme($genre);
            $movie->addTheme($theme);
        }

        $credits =  $apiService->callApi('movie/'.$_route_params['id'].'/credits');

        foreach ($credits['cast'] as $actorInfos){
            $actor = ActorFactory::createActor($actorInfos);
            $movie->addActor($actor);
        }

        $reviews = $apiService->callApi('movie/'.$_route_params['id'].'/reviews');

        foreach ($reviews['results'] as $reviewInfos){
            $review = ReviewFactory::createNotice($reviewInfos);
            $movie->addReview($review);
        }

        return $this->render('movie-details.html.twig', [
            'movie' => $movie
        ]);
    }
}