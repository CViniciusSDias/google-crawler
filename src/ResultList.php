<?php
namespace CViniciusSDias\GoogleCrawler;

use Ds\Collection;
use Ds\Vector;

class ResultList implements \IteratorAggregate
{
    /** @var Vector $results */
    private $results;

    public function __construct(int $capacity = null)
    {
        $this->results = new Vector();

        if ($capacity) {
            $this->results->allocate($capacity);
        }
    }

    public function addResult(Result $result)
    {
        $this->results->push($result);
    }

    public function getResults(): Vector
    {
        /** @var Vector $copy */
        $copy = $this->results->copy();
        return $copy;
    }

    /** {@inheritdoc} */
    public function getIterator()
    {
        return $this->results->getIterator();
    }
}
