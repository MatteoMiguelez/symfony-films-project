<?php

namespace App\Controller;

use App\Entity\Review, App\Entity\User;
use App\Factory\ActorFactory, App\Factory\FavouriteFactory, App\Factory\ReviewFactory, App\Factory\SerieFactory;
use App\Factory\WatchProviderFactory;
use App\Form\ReviewForm, App\Form\SearchBarForm;
use App\Service\apiService;
use App\Service\FavouriteService;
use App\Service\SerieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request, Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/serie')]
class SerieController extends AbstractController
{
    #[Route('/toprated', name:"getSeries")]
    public function getTopRatedSeries(apiService $apiService, EntityManagerInterface $entityManager, Request $request): Response
    {
        $serieList = $apiService->getTopRatedSeries()['results'];
        $favouritesIds = FavouriteService::getFavouriteSeriesIds($entityManager, $this->getUser());

        $series = [];
        foreach ($serieList as $serieApi){
            $series[] = SerieFactory::createSerie($serieApi, in_array($serieApi['id'], $favouritesIds));
        }

        $form = $this->createForm(SearchBarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('searchSerieByName', ['name'=> $data["search"]]);
        }

        return $this->render('list-card.html.twig', [
            'list' => $series,
            'isMovie' => false,
            'title' => "Top rated series",
            'form' => $form
        ]);
    }

    #[Route('/{id}', name:"getSerieById")]
    public function getSerieById(int $id, apiService $apiService, EntityManagerInterface $entityManager, Request $request): Response
    {
        $serie = SerieService::getSerieById($id, $apiService, $entityManager);

        $newReview = new Review();
        $newReview->setSerieId($id);

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
            return $this->redirectToRoute('getSerieById', ['id'=> $id]);
        }

        $existingReview = false;
        if ($entityManager->getRepository(Review::class)->findBy(["user" => $connectedUser, "serieId" => $id])) $existingReview= true;

        return $this->render('details/serie-details.html.twig', [
            'serie' => $serie,
            'form' => $form,
            'existingReview' => $existingReview
        ]);
    }

    #[Route('/search/{name}', name: "searchSerieByName")]
    public function searchSerie(string $name, apiService $apiService, EntityManagerInterface $entityManager,  Request $request) : Response{
        $favouritesIds = FavouriteService::getFavouriteSeriesIds($entityManager, $this->getUser());
        $serieList = $apiService->searchSerieByName($name)['results'];

        $series = [];
        foreach ($serieList as $serieApi){
            $series[] = SerieFactory::createSerie($serieApi, in_array($serieApi['id'], $favouritesIds));
        }

        $form = $this->createForm(SearchBarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('searchSerieByName', ['name'=> $data["search"]]);
        }

        return $this->render('list-card.html.twig', [
            'list' => $series,
            'isMovie' => false,
            'title' => "Series with : ".$name,
            'form' => $form
        ]);
    }
}