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


        $kProxy = new KProxy(9);
        static::assertInstanceOf(KProxy::class, $kProxy);
    }

    public function testParseUrl()
    {
        $kProxy = new KProxy(3);
        $url = 'http://server3.kproxy.com/servlet/redirect.srv/swh/suxm/sqyudex/spqr/p1/url?q=https://fast.com/&sa=U&ved=0ahUKEwiekvSC85TiAhVVtnEKHfXdB6oQFggeMAE&usg=AOvVaw3Gfn1Du48noPEZc_vSYVDD';
        $parsedUrl = $kProxy->parseUrl($url);

        $this->assertEquals('https://fast.com/', $parsedUrl);
    }

    /**
     * @dataProvider getInvalidUrls
     */
    public function testInvalidUrlsMustThrowException()
    {
        $this->expectException(InvalidResultException::class);
        $invalidUrl = 'http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw';
        $kProxy = new KProxy(3);
        $kProxy->parseUrl($invalidUrl);
    }

    public function getInvalidUrls(): array
    {
        return [
            ['http://google.com/search?q=Test&num=100&ie=UTF-8&prmd=ivnsla&source=univ&tbm=nws&tbo=u&sa=X&ved=0ahUKEwiF5PS6w6vSAhWJqFQKHQ_wBDAQqAIIKw'], // Google Suggestion
            ['https://books.google.com.br/books?id=Ft-8DgAAQBAJ&printsec=frontcover&dq=Livro+Casa+do+C%C3%B3digo&hl=pt-BR&sa=X&ved=0ahUKEwiCv4bF8ZTiAhVzI7kGHdk-Bh4Q6AEIKTAA'] // Book Link
        ];
    }
}
