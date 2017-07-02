<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Proxy\{
    GoogleProxy, NoProxy
};
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Symfony\Component\DomCrawler\Link;
use DOMElement;

/**
 * Google Crawler
 *
 * @package CViniciusSDias\GoogleCrawler
 * @author Vinicius Dias
 */
class Crawler
{
    /** @var string $url*/
    protected $url;
    /** @var GoogleProxy $proxy */
    protected $proxy;

    public function __construct(SearchTermInterface $searchTerm, GoogleProxy $proxy = null)
    {
        // You can concatenate &gl=XX replacing XX with your country code (BR = Brazil; US = United States)
        // You should also add the coutry specific part of the google url, (like .br or .es)
        $this->url = "http://www.google.com/search?q=$searchTerm&num=100";
        $this->proxy = is_null($proxy) ? new NoProxy() : $proxy;
    }

    /**
     * Returns the 100 first found results for the specified search term
     *
     * @return ResultList
     * @throws \GuzzleHttp\Exception\ServerException If the proxy was overused
     * @throws \GuzzleHttp\Exception\ConnectException If the proxy is unavailable
     */
    public function getResults(): ResultList
    {
        /** @var ResponseInterface $response */
        $response = $this->proxy->getHttpResponse($this->url);
        $stringResponse = (string) $response->getBody();
        $domCrawler = new DomCrawler($stringResponse);
        $googleResults = $domCrawler->filterXPath('//div[@class="g" and h3[@class="r" and a]]');
        $resultList = new ResultList($googleResults->count());

        foreach ($googleResults as $result) {
            $resultCrawler = new DomCrawler($result);
            $linkElement = $resultCrawler->filterXPath('//h3[@class="r"]/a')->getNode(0);
            $resultLink = new Link($linkElement, 'http://google.com/');
            $descriptionElement = $resultCrawler->filterXPath('//span[@class="st"]')->getNode(0);
            try {
                $googleResult = $this->parseResult($resultLink, $descriptionElement);
                $resultList->addResult($googleResult);
            } catch (InvalidResultException $invalidResult) {
                // TODO Maybe log this exception. Other than that, there's nothing to do, cause it isn't an error.
            }
        }

        return $resultList;
    }

    /**
     * If $resultLink is a valid link, this method assembles the Result and adds it to $googleResults
     *
     * @param Link $resultLink
     * @param DOMElement $descriptionElement
     * @return Result
     * @throws InvalidResultException
     */
    private function parseResult(Link $resultLink, DOMElement $descriptionElement): Result
    {
        $description = $descriptionElement->nodeValue
            ?? 'A description for this result isn\'t available due to the robots.txt file.';

        $googleResult = new Result();
        $googleResult
            ->setTitle($resultLink->getNode()->nodeValue)
            ->setUrl($this->getUrl($resultLink->getUri()))
            ->setDescription($description);

        return $googleResult;
    }

    /**
     * Parses the URL using the parser provided by $proxy
     *
     * @param string $url
     * @return string
     * @throws InvalidResultException
     */
    private function getUrl(string $url): string
    {
        return $this->proxy->parseUrl($url);
    }
}
