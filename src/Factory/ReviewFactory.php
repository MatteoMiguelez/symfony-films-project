<?php

namespace App\Factory;

use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;

class ReviewFactory
{
    public static function createReview(array $json) : Review {
        $review = new Review();
        $review->setNote($json['author_details']['rating'] == null ? null : (float)$json['author_details']['rating']);
        $review->setComment($json['content'] == null ? '' : $json['content']);
        $review->setUserName($json['author_details']['username'] == null ? '' : $json['author_details']['username']);
        return $review;
    }

    public static function getMovieReviews(int $movieId, EntityManagerInterface $entityManager){
        return $entityManager->getRepository(Review::class)->findBy(["movieId" => $movieId]);
    }

    public static function getSerieReviews(int $serieId, EntityManagerInterface $entityManager){
       return $entityManager->getRepository(Review::class)->findBy(["serieId" => $serieId]);
    }
}