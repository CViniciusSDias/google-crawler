<?php
namespace CViniciusSDias\GoogleCrawler;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Proxy\{
    GoogleProxyInterface, NoProxy
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
    /** @var GoogleProxyInterface $proxy */
    protected $proxy;
    /** @var SearchTermInterface $searchTerm */
    private $searchTerm;
    /** @var string $countrySpecificSuffix */
    private $googleDomain;
    /** @var string $countryCode */
    private $countryCode;

    public function __construct(
        SearchTermInterface $searchTerm, GoogleProxyInterface $proxy = null,
        string $googleDomain = 'google.com', string $countryCode = ''
    ) {
        $this->proxy = is_null($proxy) ? new NoProxy() : $proxy;
        $this->searchTerm = $searchTerm;

        if (mb_stripos($googleDomain, 'google.') === false || mb_stripos($googleDomain, 'http') === 0) {
            throw new \InvalidArgumentException('Invalid google domain');
        }
        $this->googleDomain = $googleDomain;

        $this->countryCode = mb_strtoupper($countryCode);
    }

    /**
     * Returns the 100 first found results for the specified search term
     *
     * @return ResultList
     * @throws \GuzzleHttp\Exception\ServerException If the proxy was overused
     * @throws \GuzzleHttp\Exception\ConnectException If the proxy is unavailable or $countrySpecificSuffix is invalid
     */
    public function getResults(): ResultList
    {
        $googleUrl = $this->getGoogleUrl();
        /** @var ResponseInterface $response */
        $response = $this->proxy->getHttpResponse($googleUrl);
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
                if (is_null($descriptionElement) || $this->isImageSuggestion($resultCrawler)) {
                    throw new InvalidResultException();
                }

                $googleResult = $this->parseResult($resultLink, $descriptionElement);
                $resultList->addResult($googleResult);
            } catch (InvalidResultException $invalidResult) {
                // Maybe log this exception. Other than that, there's nothing to do, cause it isn't an error.
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
            ->setUrl($this->parseUrl($resultLink->getUri()))
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
    private function parseUrl(string $url): string
    {
        return $this->proxy->parseUrl($url);
    }

    /**
     * Assembles the Google URL using the previously informed data
     */
    private function getGoogleUrl(): string
    {
        $domain = $this->googleDomain;
        $url = "https://$domain/search?q={$this->searchTerm}&num=100";
        if (!empty($this->countryCode)) {
            $url .= "&gl={$this->countryCode}";
        }

        return $url;
    }

    private function isImageSuggestion(DomCrawler $resultCrawler)
    {
        $resultCount = $resultCrawler
            ->filterXpath('//div/a')
            ->count();

        return $resultCount > 0;
    }
}
