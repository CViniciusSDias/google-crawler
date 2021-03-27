<?php

namespace CViniciusSDias\GoogleCrawler\Proxy\HttpClient;

use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class NoProxyGoogleHttpClient implements GoogleHttpClient
{
    public function getHttpResponse(string $url): ResponseInterface
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException("Invalid Google URL: $url");
        }

        return (new Client())->request('GET', $url);
    }
}
