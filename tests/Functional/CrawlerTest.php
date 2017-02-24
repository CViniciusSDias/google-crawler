<?php
namespace CViniciusSDias\GoogleCrawler;

use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    public function testSearchResultsWithOutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm);

        $results = $crawler->getResults();
        static::assertNotEmpty($results);

        file_put_contents('results.txt', print_r($results->getResults(), true));
    }
}
