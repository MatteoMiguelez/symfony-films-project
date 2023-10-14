<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Factory\ActorFactory;
use App\Factory\FavouriteFactory;
use App\Factory\MovieFactory;
use App\Factory\ReviewFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\apiService;

#[Route('/movie')]
class MovieController extends AbstractController
{

    #[Route('/all', name:"getMovies")]
   public function getMovies(apiService $apiService, EntityManagerInterface $entityManager): Response
    {
        $movieList = $apiService->getPopularMovies()['results'];
        $favouritesIds = FavouriteFactory::getFavouriteMoviesIds($entityManager);

        $movies = [];
        foreach ($movieList as $movieApi){
            $movies[] = MovieFactory::createMovie($movieApi, in_array($movieApi['id'], $favouritesIds));
        }

        return $this->render('list-card.html.twig', [
            'list' => $movies,
            'isMovie' => true,
            'title' => "Popular films"
        ]);
    }

     #[Route('/{id}', name:"getMovieById")]
    public function getMovieById(int $id, apiService $apiService): Response
    {

        $movieApi = $apiService->getMovieById($id);
        $credits = $apiService->getFilmCredits($id);
        $reviews = $apiService->getMovieReviews($id);

        $movie = MovieFactory::createMovie($movieApi);

        foreach ($credits['cast'] as $actorInfos){
            $movie->addActor(ActorFactory::createActor($actorInfos));
        }

        foreach ($reviews['results'] as $reviewInfos){
            $movie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        return $this->render('movie-details.html.twig', [
            'movie' => $movie
        ]);
    }
}