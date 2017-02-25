<?php
namespace CViniciusSDias\GoogleCrawler\Proxy;

use PHPUnit\Framework\TestCase;

class CommonProxyTest extends TestCase
{
    /**
     * @expectedException \CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException
     */
    public function testInstantiateCommonProxyWithInvalidUrlMusThrowException()
    {
        $invalidUrl = 'Invalid URL';
        /** @noinspection PhpUnusedLocalVariableInspection */
        $commonProxy = new CommonProxy($invalidUrl);
    }
}
