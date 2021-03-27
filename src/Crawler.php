<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Exception\InvalidGoogleHtmlException;
use CViniciusSDias\GoogleCrawler\Proxy\GoogleProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\GoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\Proxy\UrlParser\GoogleUrlParser;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Google Crawler
 *
 * @package CViniciusSDias\GoogleCrawler
 * @author Vinicius Dias
 */
class Crawler
{
    private GoogleHttpClient $httpClient;
    private GoogleUrlParser $urlParser;

    public function __construct(
        GoogleProxyAbstractFactory $factory = null
    ) {
        if ($factory === null) {
            $factory = new NoProxyAbstractFactory();
        }

        $this->httpClient = $factory->createGoogleHttpClient();
        $this->urlParser = $factory->createGoogleUrlParser();
    }

    /**
     * Returns the 100 first found results for the specified search term
     *
     * @param SearchTermInterface $searchTerm
     * @param string $googleDomain
     * @param string $countryCode
     * @return ResultList
     */
    public function getResults(
        SearchTermInterface $searchTerm,
        string $googleDomain = 'google.com',
        string $countryCode = ''
    ): ResultList
    {
        if (stripos($googleDomain, 'google.') === false || stripos($googleDomain, 'http') === 0) {
            throw new \InvalidArgumentException('Invalid google domain');
        }

        $googleUrl = "https://$googleDomain/search?q={$searchTerm}&num=100";
        if (!empty($countryCode)) {
            $googleUrl .= "&gl={$countryCode}";
        }
        $response = $this->httpClient->getHttpResponse($googleUrl);
        $stringResponse = (string) $response->getBody();
        $domCrawler = new DomCrawler($stringResponse);
        $googleResultList = $this->createGoogleResultList($domCrawler);

        $resultList = new ResultList($googleResultList->count());

        $domElementParser = new DomElementParser($this->urlParser);
        foreach ($googleResultList as $googleResultElement) {
            $parsedResultMaybe = $domElementParser->parse($googleResultElement);
            $parsedResultMaybe
                ->select(fn (Result $parsedResult) => $resultList->addResult($parsedResult));
        }

        return $resultList;
    }

    private function createGoogleResultList(DomCrawler $domCrawler): DomCrawler
    {
        $googleResultList = $domCrawler->filterXPath('//div[@class="ZINbbc xpd O9g5cc uUPGi"]');
        if ($googleResultList->count() === 0) {
            throw new InvalidGoogleHtmlException('No parsable element found');
        }

        return $googleResultList;
    }
}
