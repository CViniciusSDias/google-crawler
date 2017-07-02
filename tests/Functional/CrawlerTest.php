<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Proxy\CommonProxy;
use CViniciusSDias\GoogleCrawler\Proxy\KProxy;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\TestCase;

class CrawlerTest extends TestCase
{
    public function testSearchResultsWithoutProxy()
    {
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm);

        $results = $crawler->getResults();
        $this->checkResults($results);
    }

    /**
     * @dataProvider getCommonEndpoints
     * @param string $endpoint
     */
    public function testSearchResultsWithCommonProxy(string $endpoint)
    {
        $commonProxy = new CommonProxy($endpoint);
        $searchTerm = new SearchTerm('Test');
        $crawler = new Crawler($searchTerm, $commonProxy);
        $results = $crawler->getResults();

        $this->checkResults($results);
    }

    /**
     * @dataProvider getKProxyServerNumbers
     * @param int $serverNumber
     */
    public function testSearchResultsWithKProxy(int $serverNumber)
    {
        try {
            $kProxy = new KProxy($serverNumber);
            $searchTerm = new SearchTerm('Test');
            $crawler = new Crawler($searchTerm, $kProxy);
            $results = $crawler->getResults();

            $this->checkResults($results);
        } catch (ServerException | ConnectException $e) {
            static::markTestSkipped('Proxy is unavailable for google searches now.');
        }
    }

    /**
     * Get the known endpoints for the CommonProxy class
     *
     * @return array
     */
    public function getCommonEndpoints(): array
    {
        return [
            ['https://us.hideproxy.me/includes/process.php?action=update'],
            ['https://nl.hideproxy.me/includes/process.php?action=update'],
            ['https://de.hideproxy.me/includes/process.php?action=update']
        ];
    }

    /**
     * Get the available server numbers for the KProxy class
     *
     * @return array
     */
    public function getKProxyServerNumbers(): array
    {
        return [
            [1], [2], [3], [4], [5], [6], [7], [8], [9]
        ];
    }

    /**
     * Check if there are results and if they are valid
     *
     * @param ResultList $results
     */
    public function checkResults(ResultList $results): void
    {
        static::assertNotEmpty($results->getResults());

        /** @var Result $result */
        foreach ($results as $result) {
            static::assertInstanceOf(Result::class, $result);
            static::assertTrue(filter_var($result->getUrl(), FILTER_VALIDATE_URL) !== false);
            static::assertNotEmpty($result->getTitle());
            static::assertNotNull($result->getDescription());
        }
    }
}
