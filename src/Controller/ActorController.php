<?php

namespace App\Controller;

use App\Factory\ActorFactory;
use App\Factory\MovieFactory;
use App\Factory\ReviewFactory;
use App\Service\apiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('actor')]
class ActorController extends AbstractController
{
    #[Route('/{id}', name:"actor-details")]
    public function getActorDetails(apiService $apiService, array $_route_params): Response
    {
        $actorApi = $apiService->getActorById($_route_params['id']);

        $actor = ActorFactory::createDetailedActor($actorApi);

        return $this->render('actor-details.html.twig', [
            'actor' => $actor
        ]);
    }
}