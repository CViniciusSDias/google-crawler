<?php

namespace CViniciusSDias\GoogleCrawler\Proxy\UrlParser;

interface GoogleUrlParser
{
    public function parseUrl(string $googleUrl): string;
}
