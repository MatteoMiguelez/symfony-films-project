<?php

namespace App\Controller;

use App\Factory\ActorFactory;
use App\Service\apiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/actor')]
class ActorController extends AbstractController
{
    #[Route('/{id}', name:"actor-details")]
    public function getActorDetails(int $id, apiService $apiService): Response
    {
        $actorApi = $apiService->getActorById($id);
        $actor = ActorFactory::createDetailedActor($actorApi);

        return $this->render('details/actor-details.html.twig', [
            'actor' => $actor
        ]);
    }
}