<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class that for using the kproxy.com servers
 *
 * @package CViniciusSDias\GoogleCrawler\Proxy
 * @author Vinicius Dias
 */
class KProxy implements GoogleProxyInterface
{
    /** @var string $endpoint */
    protected $endpoint;
    /** @var int $serverNumber */
    protected $serverNumber;

    /**
     * Constructor that initializes the proxy service in one of its servers, which go from 1 to 9
     *
     * @param int $serverNumber
     */
    public function __construct(int $serverNumber)
    {
        if ($serverNumber > 9 || $serverNumber < 1) {
            throw new \InvalidArgumentException();
        }
        $this->serverNumber = $serverNumber;
        $this->endpoint = "http://server{$serverNumber}.kproxy.com";
    }

    /**
     * {@inheritdoc}
     * @throws \GuzzleHttp\Exception\ServerException If the proxy was overused
     * @throws \GuzzleHttp\Exception\ConnectException If the proxy is unavailable
     */
    public function getHttpResponse(string $url): ResponseInterface
    {
        $httpClient = new Client(['cookies' => true]);
        $this->accessMainPage($httpClient);
        $this->sendRequestToProxy($httpClient, $url);

        $parsedUrl = parse_url($url);
        $queryString = $parsedUrl['query'];
        $actualUrl = "{$this->endpoint}/servlet/redirect.srv/swh/suxm/sqyudex/spqr/p1/search?{$queryString}";

        return $httpClient->request('GET', $actualUrl);
    }

    /**
     * Accesses the main page of the kproxy.com server. This is mandatory.
     *
     * @param Client $httpClient
     */
    private function accessMainPage(Client $httpClient): void
    {
        $httpClient->request('GET', "{$this->endpoint}/index.jsp");
    }

    /** {@inheritdoc} */
    public function parseUrl(string $url): string
    {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $link);

        if (!array_key_exists('q', $link)) {
            // Generally a book suggestion
            throw new InvalidResultException();
        }

        $url = filter_var($link['q'], FILTER_VALIDATE_URL);
        // If this is not a valid URL, so the result is (probably) an image, news or video suggestion
        if (!$url) {
            throw new InvalidResultException();
        }

        return $url;
    }

    /**
     * Sends the request to the proxy service that saves the info in session. After this we can redirect
     * the user to the search results
     *
     * @param Client $httpClient
     * @param string $url
     */
    private function sendRequestToProxy(Client $httpClient, string $url): void
    {
        $encodedUrl = urlencode($url);
        $postData = ['page' => $encodedUrl, 'x' => 0, 'y' => 0];
        $headers = [
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'
        ];
        $httpClient->request(
            'POST',
            "{$this->endpoint}/doproxy.jsp",
            ['form_params' => $postData, 'headers' => $headers]
        );
    }
}
