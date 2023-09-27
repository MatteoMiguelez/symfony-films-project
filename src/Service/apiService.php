<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class apiService
{

    public function __construct(private readonly HttpClientInterface $tmbdClient)
    {
    }

    public function callApi($url): array
    {
        $response = $this->tmbdClient->request('GET', $url);
        $content = $response->toArray();
        return $content;
    }
}