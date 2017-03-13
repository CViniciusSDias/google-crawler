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
    public function testInstantiateWithServerNumberBiggetThanNineMustThrowException()
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $kProxy = new KProxy(10);
    }

    public function testInstantiateWithServerNumberBetweenOneAndNineMustNotThrowException()
    {
        $kProxy = new KProxy(1);
        static::assertInstanceOf(KProxy::class, $kProxy);
    }
}
