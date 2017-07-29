<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class that can be used for multiple proxies services, including hideproxy.me, onlinecollege.info, zend2, etc.
 *
 * @package CViniciusSDias\GoogleCrawler\Proxy
 * @author Vinicius Dias
 */
class CommonProxy implements GoogleProxyInterface
{
    /** @var string $endpoint */
    protected $endpoint;

    /**
     * Constructor that initializes the specific proxy service
     *
     * @param string $endpoint Specific service URL
     * @throws InvalidUrlException
     */
    public function __construct(string $endpoint)
    {
        if (!filter_var($endpoint, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException("Invalid CommonProxy endpoint: $endpoint");
        }

        $this->endpoint = $endpoint;
    }

    /** {@inheritdoc} */
    public function getHttpResponse(string $url): ResponseInterface
    {
        $data = ['u' => $url, 'allowCookies' => 'on'];
        $httpClient = new Client(['cookies' => true, 'verify' => false]);
        $response = $httpClient->request('POST', $this->endpoint, ['form_params' => $data]);

        return $response;
    }

    /** {@inheritdoc} */
    public function parseUrl(string $url): string
    {
        $link = parse_url($url);
        parse_str($link['query'], $link);

        parse_str($link['u'], $link);
        $link = array_values($link);

        $url = filter_var($link[0], FILTER_VALIDATE_URL);
        // If this is not a valid URL, so the result is (probably) an image, news or video suggestion
        if (!$url) {
            throw new InvalidResultException();
        }

        return $url;
    }
}
