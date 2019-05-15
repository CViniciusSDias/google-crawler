<?php
namespace CViniciusSDias\GoogleCrawler\Tests\Functional;

use CViniciusSDias\GoogleCrawler\Result;
use CViniciusSDias\GoogleCrawler\ResultList;
use PHPUnit\Framework\TestCase;

abstract class AbstractCrawlerTest extends TestCase
{
    /**
     * Check if there are results and if they are valid
     *
     * @param ResultList $results
     */
    public function checkResults(ResultList $results): void
    {
        static::assertNotEmpty($results->getResults());

        /** @var Result $result */
        foreach ($results as $result) {
            static::assertInstanceOf(Result::class, $result);
            static::assertNotFalse(filter_var($result->getUrl(), FILTER_VALIDATE_URL));
            static::assertNotEmpty($result->getTitle());
            static::assertNotNull($result->getDescription());
        }
    }
}
