<?php

namespace App\Controller;

use App\Entity\Review, App\Entity\User;
use App\Entity\WatchProvider;
use App\Factory\ActorFactory, App\Factory\FavouriteFactory, App\Factory\MovieFactory, App\Factory\ReviewFactory;
use App\Factory\WatchProviderFactory;
use App\Form\ReviewForm, App\Form\SearchBarForm;
use App\Service\FavouriteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request, Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\apiService;

#[Route('/movie')]
class MovieController extends AbstractController
{

    #[Route('/popular', name:"getMovies")]
   public function getPopularMovies(apiService $apiService, EntityManagerInterface $entityManager, Request $request): Response
    {
        $movieList = $apiService->getPopularMovies()['results'];
        $favouritesIds = FavouriteService::getFavouriteMoviesIds($entityManager, $this->getUser());

        $movies = [];
        foreach ($movieList as $movieApi){
            $movies[] = MovieFactory::createMovie($movieApi, in_array($movieApi['id'], $favouritesIds));
        }

        $form = $this->createForm(SearchBarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('searchMovieByName', ['name'=> $data["search"]]);
        }

        return $this->render('list-card.html.twig', [
            'list' => $movies,
            'isMovie' => true,
            'title' => "Popular films",
            'form' => $form
        ]);
    }

     #[Route('/{id}', name:"getMovieById")]
     public function getMovieById(int $id, apiService $apiService, EntityManagerInterface $entityManager, Request $request): Response
    {
        $movieApi = $apiService->getMovieById($id);
        $credits = $apiService->getFilmCredits($id);
        $reviews = $apiService->getMovieReviews($id);
        $watchProviders = $apiService->getMovieWatchProviders($id);

        $localReviews = $entityManager->getRepository(Review::class)->findBy(["movieId" => $id]);

        $movie = MovieFactory::createMovie($movieApi);

        if (count($credits['cast']) > 18) $credits['cast']= array_splice($credits['cast'], 0, 18);
        foreach ($credits['cast'] as $actorInfos){
            $movie->addActor(ActorFactory::createActor($actorInfos));
        }

        if (array_key_exists("FR", $watchProviders["results"]) && array_key_exists('flatrate', $watchProviders["results"]["FR"])){
            foreach ($watchProviders["results"]["FR"]["flatrate"] as $watchProviderInfos){
                $movie->addWatchProvider(WatchProviderFactory::createWatchProvider($watchProviderInfos));
            }
        }

        foreach ($localReviews as $reviewInfos){
            $movie->addReview($reviewInfos);
        }

        foreach ($reviews['results'] as $reviewInfos){
            $movie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        $newReview = new Review();
        $newReview->setMovieId($id);

        $connectedUser = $this->getUser();
        if ($connectedUser instanceof User){
            $newReview->setUser($connectedUser);
            $newReview->setUserName($connectedUser->getEmail());
        }

        $form = $this->createForm(ReviewForm::class, $newReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newReview);
            $entityManager->flush();
            return $this->redirectToRoute('getMovieById', ['id'=> $id]);
        }

        $existingReview = false;
        if ($entityManager->getRepository(Review::class)->findBy(["user" => $connectedUser, "movieId" => $id])) $existingReview= true;

        return $this->render('details/movie-details.html.twig', [
            'movie' => $movie,
            'form' => $form,
            'existingReview' => $existingReview
        ]);
    }

    #[Route('/search/{name}', name: "searchMovieByName")]
    public function searchMovie(string $name, apiService $apiService, EntityManagerInterface $entityManager,  Request $request) : Response{
        $favouritesIds = FavouriteService::getFavouriteMoviesIds($entityManager, $this->getUser());
        $movieList = $apiService->searchMovieByName($name)["results"];

        $movies = [];
        foreach ($movieList as $movieApi){
            $movies[] = MovieFactory::createMovie($movieApi, in_array($movieApi['id'], $favouritesIds));
        }

        $form = $this->createForm(SearchBarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('searchMovieByName', ['name'=> $data["search"]]);
        }

        return $this->render('list-card.html.twig', [
            'list' => $movies,
            'isMovie' => true,
            'title' => "Movies with : ".$name,
            'form' => $form
        ]);
    }
}