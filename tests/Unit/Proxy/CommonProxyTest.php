<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit\Proxy;

use CViniciusSDias\GoogleCrawler\Exception\InvalidResultException;
use CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException;
use CViniciusSDias\GoogleCrawler\Proxy\CommonProxy;
use PHPUnit\Framework\TestCase;

class CommonProxyTest extends TestCase
{
    public function testInstantiateCommonProxyWithInvalidUrlMustThrowException()
    {
        $this->expectException(InvalidUrlException::class);
        $invalidUrl = 'Invalid URL';
        new CommonProxy($invalidUrl);
    }

    public function testUrlMustBeCorrectlyParsed()
    {
        $url = 'http://google.com/go.php?u=http%3A%2F%2Fwww.google.com%2Furl%3Fq%3Dhttps%3A%2F%2Fwww.test.com%2F%26sa%3DU%26ved%3D0ahUKEwjP1_SG7a7SAhVHfiYKHfoJBecQFggUMAA%26usg%3DAFQjCNFv81BNTFv07pRUSOCLn6uWFrHWVA&b=4';
        $commonProxy = new CommonProxy('http://example.com');
        static::assertEquals('https://www.test.com/', $commonProxy->parseUrl($url));
    }

    public function testUrlFromGoogleSuggestionMustThrowInvalidResultException()
    {
        $this->expectException(InvalidResultException::class);
        $noProxy = new CommonProxy('http://example.com');
        $invalidUrl = 'http://google.com/go.php?u=http%3A%2F%2Fgoogle.com%2Fsearch%3Fq%3DTest%26num%3D100%26ie%3DUTF-8%26prmd%3Divnsla%26source%3Duniv%26tbm%3Dnws%26tbo%3Du%26sa%3DX%26ved%3D0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw&b=4';
        $noProxy->parseUrl($invalidUrl);
    }
}
