<?php

namespace App\Controller;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/review')]
class ReviewController extends AbstractController
{
    #[Route('/', name: 'reviewList')]
    public function getReviewList(EntityManagerInterface $entityManager): Response
    {
        $userReviews = $entityManager->getRepository(Review::class)->findBy(["user" => $this->getUser()]);

        return $this->render('review/reviewList.html.twig', [
            'userReviews' => $userReviews,
        ]);
    }
}
