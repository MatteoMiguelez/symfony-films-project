<?php

namespace App\Factory;

use App\Entity\Review;

class ReviewFactory
{
    public static function createNotice(array $json) : Review {
        $review = new Review();
        $review->setNote($json['author_details']['rating'] == null ? null : (float)$json['author_details']['rating']);
        $review->setComment($json['content'] == null ? '' : $json['content']);
        $review->setUserName($json['author_details']['username'] == null ? '' : $json['author_details']['username']);
        return $review;
    }
}