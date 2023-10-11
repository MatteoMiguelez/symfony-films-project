<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiService
{

    public function __construct(private readonly HttpClientInterface $tmbdClient)
    {
    }

    public function callApi($url): array
    {
        $response = $this->tmbdClient->request('GET', $url);
        return $response->toArray();
    }

    public function getPopularMovies(): array{
        return $this->callApi('movie/popular');
    }

    public function getMovieById(int|null $id) : array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id);
    }

    public function getFilmCredits(int|null $id) : array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id.'/credits');
    }

    public function getMovieReviews(int|null $id): array{
        if ($id == null) return [];
        return $this->callApi('movie/'.$id.'/reviews');
    }
}