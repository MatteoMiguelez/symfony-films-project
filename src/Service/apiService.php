<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiService
{

    public function __construct(private readonly HttpClientInterface $tmbdClient){}

    public function callApi($url): array
    {
        $response = $this->tmbdClient->request('GET', $url);
        return $response->toArray();
    }

    public function getPopularMovies(): array{
        return $this->callApi('movie/popular');
    }

    public function getMovieById(?int $id) : array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id);
    }

    public function getFilmCredits(?int $id) : array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id.'/credits');
    }

    public function getMovieReviews(?int $id): array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id.'/reviews');
    }

    public function getTopRatedSeries(): array{
        return $this->callApi('tv/top_rated');
    }

    public function getSerieById(?int $id) : array{
        if ($id == null) return [];
        return $this->callApi('tv/'.$id);
    }

    public function getSerieCredits(?int $id) : array{
        if ($id == null) return [];
        return $this->callApi('tv/'.$id.'/credits');
    }

    public function getSerieReviews(?int $id): array{
        if ($id == null) return [];
        return $this->callApi('tv/'.$id.'/reviews?language=en-US');
    }

    public function getActorById(?int $id): array{
        if ($id == null) return [];
        return $this->callApi('person/'.$id);
    }

    public function searchMovieByName(string $name): array{
        return $this->callApi('search/movie?query='.$name);
    }

    public function searchSerieByName(string $name): array{
        return $this->callApi('search/tv?query='.$name);
    }

}