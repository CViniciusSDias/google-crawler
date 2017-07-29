<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Proxy\NoProxy;
use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    public function testCrawlerGetsCorrectUrlWithCountrySpecificSuffixWithoutDot()
    {
        $crawler = new Crawler(new SearchTerm('Test'), new NoProxy(), 'br', 'BR');
        $url = $this->getUrlFromCrawler($crawler);

        static::assertEquals('https://www.google.com.br/search?q=Test&num=100&gl=BR', $url);
    }

    public function testCrawlerGetsCorrectUrlWithCountrySpecificSuffixWithDot()
    {
        $crawler = new Crawler(new SearchTerm('Test'), new NoProxy(), '.br', 'BR');
        $url = $this->getUrlFromCrawler($crawler);

        static::assertEquals('https://www.google.com.br/search?q=Test&num=100&gl=BR', $url);
    }

    public function testDefaultCrawlerGetsCorrectUrl()
    {
        $crawler = new Crawler(new SearchTerm('Test'));
        $url = $this->getUrlFromCrawler($crawler);

        static::assertEquals('https://www.google.com/search?q=Test&num=100', $url);
    }

    private function getUrlFromCrawler(Crawler $crawler): string
    {
        $reflectionClass = new \ReflectionClass($crawler);
        $reflectionMethod = $reflectionClass->getMethod('getGoogleUrl');
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invoke($crawler);
    }

}
