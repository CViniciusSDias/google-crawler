<?php
namespace CViniciusSDias\GoogleCrawler;

require_once __DIR__ . '/AbstractCrawlerTest.php';
use CViniciusSDias\GoogleCrawler\Proxy\NoProxy;
use GuzzleHttp\Exception\GuzzleException;

class PersonalizedCrawlerTest extends AbstractCrawlerTest
{
    public function testSearchOnBrazilianGoogleWithoutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm, new NoProxy(), 'google.com.br', 'BR');

        $results = $crawler->getResults();
        $this->checkResults($results);
    }

    public function testSearchWithInvalidCountrySuffixMustFail()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm, new NoProxy(), 'google.ab');

        try {
            $crawler->getResults();
            static::fail();
        } catch (\Throwable $exception) {
            if ($exception instanceof GuzzleException) {
                static::assertTrue(true);
            }
        }
    }
}
