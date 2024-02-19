<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieAPIController extends AbstractController
{
    private const API_URL = 'https://moviesdatabase.p.rapidapi.com/titles';
    private const API_KEY = '9748c19636msh8c15e691eb6263fp1e8f5bjsnf18cef8994bc';

    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

    #[Route('/movie/api', name: 'app_movie_a_p_i')]
    public function index(): Response
    {
        $response = $this->httpClient->request('GET', self::API_URL, [
            'headers' => [
                'X-RapidAPI-Key' => self::API_KEY,
                'X-RapidAPI-Host' => 'moviesdatabase.p.rapidapi.com',
            ],
            'query' => [
                'year' => '2022',
                'page' => '2',
            ]
        ]);

        $contentType = $response->getHeaders()['content-type'][0];

        $data = $response->toArray();

        return $this->render('movie_api/index.html.twig', [
            'data' => $data,
        ]);
    }
}
