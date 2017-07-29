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
        // Separates the url parts
        $link = parse_url($url);
        // Parses the parameters of the url query
        parse_str($link['query'], $link);

        $url = filter_var($link['q'], FILTER_VALIDATE_URL);
        // If this is not a valid URL, so the result is (probably) an image, news or video suggestion
        if (!$url) {
            throw new InvalidResultException();
        }

        return $url;
    }
}
