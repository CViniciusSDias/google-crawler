<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Proxy\KProxy;
use PHPUnit\Framework\TestCase;

class KProxyTest extends TestCase
{
    public function testInstantiateWithServerNumberLowerThanOneMustThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new KProxy(0);
    }

    public function testInstantiateWithServerNumberBiggerThanNineMustThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new KProxy(10);
    }

    public function testInstantiateWithServerNumberBetweenOneAndNineMustNotThrowException()
    {
        $kProxy = new KProxy(1);
        static::assertInstanceOf(KProxy::class, $kProxy);
    }

    public function testUrlFromGoogleSuggestionMustThrowInvalidResultException()
    {
        $this->expectException(InvalidResultException::class);
        $invalidUrl = 'http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw';
        $kProxy = new KProxy(3);
        $kProxy->parseUrl($invalidUrl);
    }
}
