<?php

namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\GoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\NoProxyGoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\UrlParser\GoogleUrlParser;
use CViniciusSDias\GoogleCrawler\Proxy\UrlParser\NoProxyGoogleUrlParser;

class NoProxyAbstractFactory implements GoogleProxyAbstractFactory
{
    public function createGoogleHttpClient(): GoogleHttpClient
    {
        return new NoProxyGoogleHttpClient();
    }

    public function createGoogleUrlParser(): GoogleUrlParser
    {
        return new NoProxyGoogleUrlParser();
    }
}
