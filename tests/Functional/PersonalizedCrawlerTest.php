<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Functional;

use CViniciusSDias\GoogleCrawler\Crawler;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxy;
use CViniciusSDias\GoogleCrawler\SearchTerm;
use GuzzleHttp\Exception\GuzzleException;

class PersonalizedCrawlerTest extends AbstractCrawlerTest
{
    public function testSearchOnBrazilianGoogleWithoutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler(new NoProxy(), 'google.com.br', 'BR');

        $results = $crawler->getResults($searchTerm);
        $this->checkResults($results);
    }

    public function testSearchWithInvalidCountrySuffixMustFail()
    {
        $this->expectException(GuzzleException::class);
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler(new NoProxy());

        $crawler->getResults($searchTerm, 'google.ab');
    }
}
