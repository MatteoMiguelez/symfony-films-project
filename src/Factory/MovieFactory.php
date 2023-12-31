<?php

namespace App\Factory;

use App\Entity\Movie;

class MovieFactory
{
    public static function createMovie(array $json, bool $isFavorite = false): Movie
    {
        $movie = new Movie();
        $movie->setId($json['id'] == null ? null : $json['id']);
        $movie->setTitle($json['title'] == null ? null : $json['title']);
        $movie->setPicturePath($json['poster_path'] == null ? null : 'https://image.tmdb.org/t/p/original/'.$json['poster_path']);
        $movie->setDescription($json['overview'] == null ? null : $json['overview']);
        if ($json['release_date']) $movie->setReleaseDate($json['release_date'] == null ? null :  new \DateTime($json['release_date']));
        $movie->setLanguage($json['original_language'] == null ? null : $json['original_language']);
        $movie->setRating($json['vote_average'] == null ? null : $json['vote_average']);
        $movie->setIsAdult($json['adult'] == null ? null : $json['vote_average']);
        $movie->setIsFavorite($isFavorite);

        if(isset($json['genres'])){
            foreach ($json['genres'] as $genre) {
                $movie->addTheme(ThemeFactory::createTheme($genre));
            }
        }

        return $movie;
    }
}