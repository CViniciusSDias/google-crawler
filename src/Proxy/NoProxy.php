<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class that represents the absense of a proxy service, making the direct request to the url
 * and returning its response
 *
 * @package CViniciussDias\GoogleCrawler\Proxy
 * @author Vinicius Dias
 */
class NoProxy implements GoogleProxyInterface
{
    /** {@inheritdoc} */
    public function getHttpResponse(string $url): ResponseInterface
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException("Invalid Google URL: $url");
        }

        return (new Client())->request('GET', $url);
    }

    /** {@inheritdoc} */
    public function parseUrl(string $url): string
    {
        $urlParts = parse_url($url);
        parse_str($urlParts['query'], $queryStringParams);

        $url = filter_var($queryStringParams['q'], FILTER_VALIDATE_URL);
        if (!$url) {
            throw new InvalidResultException();
        }

        return $url;
    }
}
