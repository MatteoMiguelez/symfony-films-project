<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Review;
use App\Entity\Theme;
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
            $movie = new Movie();
            $movie->setTitle($movieApi['title']);
            $movie->setDescription($movieApi['overview']);
            $movie->setId($movieApi['id']);
            $movie->setIsAdult($movieApi['adult']);
            $movie->setRating($movieApi['vote_average']);
            $movie->setReleaseDate(new \DateTime($movieApi['release_date']));
            $movie->setPicturePath("https://image.tmdb.org/t/p/original".$movieApi['poster_path']);
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
        $movie = new Movie();
        $movie->setTitle($response['title']);
        $movie->setDescription($response['overview']);
        $movie->setId($response['id']);
        $movie->setIsAdult($response['adult']);
        $movie->setRating($response['vote_average']);
        $movie->setReleaseDate(new \DateTime($response['release_date']));
        $movie->setPicturePath("https://image.tmdb.org/t/p/original".$response['poster_path']);

        foreach ($response['genres'] as $genre){
            $theme = new Theme();
            $theme->setId($genre['id']);
            $theme->setName($genre['name']);
            //$theme->addMovie($movie);
            $movie->addTheme($theme);
        }

        $credits =  $apiService->callApi('movie/'.$_route_params['id'].'/credits');

        foreach ($credits['cast'] as $actorInfos){
            $actor = new Actor();
            $actor->setId($actorInfos['id']);
            $actor->setName($actorInfos['name']);
            if ($actorInfos['profile_path'] != null) {
                $actor->setPicturePath("https://image.tmdb.org/t/p/original" . $actorInfos['profile_path']);
            }
            $movie->addActor($actor);
        }

        $reviews = $apiService->callApi('movie/'.$_route_params['id'].'/reviews');

        foreach ($reviews['results'] as $reviewInfos){
            $review = new Review();
            $review->setId($reviewInfos['id']);
            $review->setNote($reviewInfos['author_details']['rating']);
            $review->setComment($reviewInfos['content']);
            $review->setUserName($reviewInfos['author_details']['username']);
            //$review->setMovie($movie);
            $movie->addReview($review);
        }

        return $this->render('movie-details.html.twig', [
            'movie' => $movie
        ]);
    }
}