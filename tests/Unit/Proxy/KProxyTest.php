<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use PHPUnit\Framework\TestCase;

class KProxyTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInstantiateWithServerNumberLowerThanOneMustThrowException()
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $kProxy = new KProxy(0);
    }

    /** @expectedException \InvalidArgumentException */
    public function testInstantiateWithServerNumberBiggerThanNineMustThrowException()
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $kProxy = new KProxy(10);
    }

    public function testInstantiateWithServerNumberBetweenOneAndNineMustNotThrowException()
    {
        $kProxy = new KProxy(1);
        static::assertInstanceOf(KProxy::class, $kProxy);
    }

    /**
     * @expectedException \CViniciusSDias\GoogleCrawler\Exception\InvalidResultException
     */
    public function testUrlFromGoogleSuggestionMustThrowInvalidResultException()
    {
        $invalidUrl = 'http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw';
        $kProxy = new KProxy(3);
        $kProxy->parseUrl($invalidUrl);
    }
}
