<?php

namespace App\Factory;

use App\Entity\Actor;

class ActorFactory
{
    public static function createActor(array $json) : Actor {
        $actor = new Actor();
        $actor->setId($json['id'] == null ? '' : $json['id']);
        $actor->setName($json['name'] == null ? '' : $json['name']);

        if ($json['profile_path'] != null) {
            $actor->setPicturePath("https://image.tmdb.org/t/p/original" . $json['profile_path']);
        }
        return $actor;
    }

    public static function createDetailedActor(array $json): Actor{
        $actor = self::createActor($json);
        $actor->setBiography($json['biography'] == null ? 'No data' : $json['biography']);

        if ($json['gender']){
            if ($json['gender']== 1){
                $actor->setGenre('W');
            }elseif ($json['gender'] == 2){
                $actor->setGenre('M');
            }
        }
        return $actor;
    }
}