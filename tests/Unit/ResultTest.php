<?php
namespace CViniciusSDias\GoogleCrawler;

use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    /**
     * @expectedException \CViniciusSDias\GoogleCrawler\Exception\InvalidUrlException
     */
    public function testInvalidUrlMustThrowException()
    {
        $result = new Result();
        $result->setUrl('teste');
    }

    public function testValidUrlMustNotThrowException()
    {
        $url = 'http://example.com';
        $result = new Result();
        $result->setUrl($url);

        static::assertEquals($url, $result->getUrl());
    }
}