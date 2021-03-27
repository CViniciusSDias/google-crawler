<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Functional;

use CViniciusSDias\GoogleCrawler\Crawler;
use CViniciusSDias\GoogleCrawler\Exception\InvalidGoogleHtmlException;
use CViniciusSDias\GoogleCrawler\Proxy\CommonProxy;
use CViniciusSDias\GoogleCrawler\Proxy\KProxy;
use CViniciusSDias\GoogleCrawler\SearchTerm;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;

class DefaultCrawlerTest extends AbstractCrawlerTest
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
        try {
            $results = $crawler->getResults();

            $this->checkResults($results);
        } catch (ConnectException $exception) {
            static::markTestIncomplete("Timeout error on $endpoint.");
        } catch (ClientException $e) {
            static::markTestIncomplete('Blocked by google "Too Many Requests" error');
        } catch (InvalidGoogleHtmlException $e) {
            static::markTestSkipped($e->getMessage());
        }
    }

    /**
     * @dataProvider getKProxyServerNumbers
     * @param int $serverNumber
     */
    public function testSearchResultsWithKproxy(int $serverNumber)
    {
        $this->markTestSkipped('Implementation outdated');
        try {
            $kProxy = new KProxy($serverNumber);
            $searchTerm = new SearchTerm('Test');
            $crawler = new Crawler($searchTerm, $kProxy);
            $results = $crawler->getResults();

            $this->checkResults($results);
        } catch (ServerException | ConnectException $e) {
            static::markTestIncomplete('Proxy is unavailable for google searches now.');
        } catch (ClientException $e) {
            static::markTestIncomplete('Blocked by google "Too Many Requests" error');
        } catch (InvalidGoogleHtmlException $e) {
            static::markTestSkipped($e->getMessage());
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
}
