<?php

namespace CViniciusSDias\GoogleCrawler\Proxy\HttpClient;

use Psr\Http\Message\ResponseInterface;

interface GoogleHttpClient
{
    public function getHttpResponse(string $url): ResponseInterface;
}
