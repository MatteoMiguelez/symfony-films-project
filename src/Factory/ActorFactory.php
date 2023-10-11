<?php

namespace App\Factory;

use App\Entity\Actor;

class ActorFactory
{
    public static function createActor(array $json) : Actor {
        $actor = new Actor();
        $actor->setId($json['id'] == null ? '' : $json['id']);
        if ($json['profile_path'] != null) {
            $actor->setPicturePath("https://image.tmdb.org/t/p/original" . $json['profile_path']);
        }        $actor->setName($json['name'] == null ? '' : $json['name']);
        return $actor;
    }
}