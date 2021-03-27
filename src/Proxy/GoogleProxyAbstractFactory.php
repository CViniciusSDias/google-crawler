<?php

namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\GoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\UrlParser\GoogleUrlParser;

interface GoogleProxyAbstractFactory
{
    public function createGoogleHttpClient(): GoogleHttpClient;
    public function createGoogleUrlParser(): GoogleUrlParser;
}
