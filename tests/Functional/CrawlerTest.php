<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Proxy\CommonProxy;
use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    public function testSearchResultsWithOutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm);

        $results = $crawler->getResults();
        static::assertNotEmpty($results->getResults());
    }

    public function testSearchResultsWithCommonProxy()
    {
        $endpoint = 'https://proxy-us.hideproxy.me/includes/process.php?action=update';
        $commonProxy = new CommonProxy($endpoint);
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm, $commonProxy);
        $results = $crawler->getResults();

        static::assertNotEmpty($results->getResults());
    }
}
