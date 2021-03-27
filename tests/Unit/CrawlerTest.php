<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit;

use CViniciusSDias\GoogleCrawler\Crawler;
use CViniciusSDias\GoogleCrawler\Exception\InvalidGoogleHtmlException;
use CViniciusSDias\GoogleCrawler\Proxy\GoogleProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\Proxy\GoogleProxyInterface;
use CViniciusSDias\GoogleCrawler\Proxy\HttpClient\GoogleHttpClient;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxy;
use CViniciusSDias\GoogleCrawler\Proxy\NoProxyAbstractFactory;
use CViniciusSDias\GoogleCrawler\SearchTerm;
use CViniciusSDias\GoogleCrawler\SearchTermInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CrawlerTest extends TestCase
{
    public function testTryingToGetResultsWithHttpOnGoogleDomainMustFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $domain = 'http://google.com';
        $crawler = new Crawler(new NoProxyAbstractFactory());
        $crawler->getResults(new SearchTerm(''), $domain);
    }

    public function testTryingToInstantiateACrawlerWithoutGoogleOnTheDomainMustFail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $crawler = new Crawler(new NoProxyAbstractFactory());
        $crawler->getResults(new SearchTerm(''), 'invalid-domain');
    }

    public function testTryingToParseInvalidHtmlMustThrowException()
    {
        $this->expectException(InvalidGoogleHtmlException::class);
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock->method('__toString')
            ->willReturn('<html><head></head><body>Invalid HTML</body></html>');

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getBody')
            ->willReturn($streamMock);

        $googleHttpClient = $this->createMock(GoogleHttpClient::class);
        $googleHttpClient->method('getHttpResponse')
            ->willReturn($responseMock);
        $factory = $this->createStub(GoogleProxyAbstractFactory::class);
        $factory
            ->method('createGoogleHttpClient')
            ->willReturn($googleHttpClient);

        $crawler = new Crawler($factory);
        $crawler->getResults(new SearchTerm(''));
    }
}
