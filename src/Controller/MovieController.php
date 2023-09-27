<?php

namespace App\Controller;

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
    public function getMovieById(apiService $apiService): Response
    {
        $response = $apiService->callApi('id');

        return $this->render('movie.html.twig', [
            'movies' => null
        ]);
    }
}