<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Unit;

use CViniciusSDias\GoogleCrawler\Result;
use CViniciusSDias\GoogleCrawler\ResultList;
use PHPUnit\Framework\TestCase;

class ResultListTest extends TestCase
{
    public function testAddResult()
    {
        $result = new Result();
        $list = new ResultList();
        $list->addResult($result);

        static::assertCount(1, $list->getResults());

        return $list;
    }

    /**
     * @depends testAddResult
     */
    public function testGetResultsMustReturnUnmodifiableList(ResultList $list)
    {
        $results = $list->getResults();
        $results->push(new Result());

        static::assertCount(1, $list->getResults());
        static::assertCount(2, $results);
    }
}