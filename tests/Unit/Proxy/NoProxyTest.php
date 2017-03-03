<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use PHPUnit\Framework\TestCase;

class NoProxyTest extends TestCase
{
    /**
     * @expectedException \CViniciusSDias\GoogleCrawler\Exception\InvalidResultException
     */
    public function testUrlFromGoogleSuggestionMustThrowInvalidResultException()
    {
        $noProxy = new NoProxy();
        $invalidUrl = 'http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw';
        $noProxy->parseUrl($invalidUrl);
    }

    public function testUrlMustBeCorrectlyParsed()
    {
        $noProxy = new NoProxy();
        $validUrl = 'http://google.com//url?q=http://www.speedtest.net/pt/&sa=U&ved=0ahUKEwjYuPbkxqvSAhXFQZAKHdpyAxMQFggUMAA&usg=AFQjCNFR74JMZRVu3EUNUUHa7o_1ETZoiQ';
        $url = $noProxy->parseUrl($validUrl);
        static::assertEquals('http://www.speedtest.net/pt/', $url);
    }

    /**
     * @expectedException \CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException
     */
    public function testTryingToGetHttpResponseFromInvalidUrlMustThrowException()
    {
        $noProxy = new NoProxy();
        $noProxy->getHttpResponse('teste');
    }
}
