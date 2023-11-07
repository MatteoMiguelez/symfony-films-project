<?php

namespace App\Factory;

use App\Entity\Serie;

class SerieFactory
{
    public static function createSerie(array $json, bool $isFavorite = false): Serie
    {
        $serie = new Serie();
        $serie->setId($json['id'] == null ? null : $json['id']);
        $serie->setTitle($json['name'] == null ? null : $json['name']);
        $serie->setPicturePath($json['poster_path'] == null ? null : 'https://image.tmdb.org/t/p/original/'.$json['poster_path']);
        $serie->setDescription($json['overview'] == null ? null : $json['overview']);
        $serie->setReleaseDate($json['first_air_date'] == null ? null :  new \DateTime($json['first_air_date']));
        $serie->setLanguage($json['original_language'] == null ? null : $json['original_language']);
        $serie->setRating($json['vote_average'] == null ? null : $json['vote_average']);
        $serie->setIsFavourite($isFavorite);

        if(isset($json['genres'])){
            foreach ($json['genres'] as $genre) {
                $serie->addTheme(ThemeFactory::createTheme($genre));
            }
        }

        return $serie;
    }

    public static function createSerieDetailed(array $json, bool $isFavorite = false): Serie
    {
        $serie = self::createSerie($json, $isFavorite);
        $serie->setIsAdult($json['adult'] == null ? null : $json['adult']);
        $serie->setSeasonNb($json['number_of_seasons'] == null ? null : $json['number_of_seasons']);
        $serie->setEpisodeNb($json['number_of_episodes'] == null ? null : $json['number_of_episodes']);
        $serie->setDirector($json['director'] == null ? null : $json['director']);

        return $serie;
    }
}