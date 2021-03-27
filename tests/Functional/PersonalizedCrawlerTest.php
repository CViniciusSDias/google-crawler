<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Functional;

use CViniciusSDias\GoogleCrawler\Crawler;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\SearchTerm;
use GuzzleHttp\Exception\GuzzleException;

class PersonalizedCrawlerTest extends AbstractCrawlerTest
{
    public function testSearchOnBrazilianGoogleWithoutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler(new NoProxyAbstractFactory());

        $results = $crawler->getResults(
            $searchTerm,
            'google.com.br',
            'BR'
        );
        $this->checkResults($results);
    }

    public function testSearchWithInvalidCountrySuffixMustFail()
    {
        $this->expectException(GuzzleException::class);
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler(new NoProxyAbstractFactory());

        $crawler->getResults($searchTerm, 'google.ab');
    }
}
