<?php

namespace App\Controller;

use App\Entity\Review;
use App\Factory\ActorFactory;
use App\Factory\FavouriteFactory;
use App\Factory\ReviewFactory;
use App\Factory\SerieFactory;
use App\Form\ReviewForm;
use App\Form\SearchBarForm;
use App\Service\apiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

#[Route('serie')]
    class SerieController extends AbstractController
{
    #[Route('/all', name:"getSeries")]
    public function getSeries(apiService $apiService, EntityManagerInterface $entityManager, Request $request): Response
    {
        $serieList = $apiService->getTopRatedSeries()['results'];
        $favouritesIds = FavouriteFactory::getFavouriteSeriesIds($entityManager);

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
        $serieApi = $apiService->getSerieById($id);
        $credits = $apiService->getSerieCredits($id);
        $reviews = $apiService->getSerieReviews($id);

        $localReviews = ReviewFactory::getSerieReviews($id, $entityManager);

        $serie = SerieFactory::createSerieDetailed($serieApi);

        if ($credits['cast'] && count($credits['cast']) > 18) $credits['cast']= array_splice($credits['cast'], 0, 18);

        foreach ($credits['cast'] as $actorInfos){
            $serie->addActor(ActorFactory::createActor($actorInfos));
        }

        foreach ($localReviews as $reviewInfos){
            $serie->addReview($reviewInfos);
        }

        foreach ($reviews['results'] as $reviewInfos){
            $serie->addReview(ReviewFactory::createReview($reviewInfos));
        }

        $newReview = new Review();
        $newReview->setUserName('DbUser');
        $newReview->setSerieId($id);

        $form = $this->createForm(ReviewForm::class, $newReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newReview);
            $entityManager->flush();
            return $this->redirectToRoute('getSerieById', ['id'=> $id]);
        }

        return $this->render('details/serie-details.html.twig', [
            'serie' => $serie,
            'form' => $form
        ]);
    }

    #[Route('/search/{name}', name: "searchSerieByName")]
    public function searchSerie(string $name, apiService $apiService, EntityManagerInterface $entityManager,  Request $request) : Response{
        $favouritesIds = FavouriteFactory::getFavouriteSeriesIds($entityManager);
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